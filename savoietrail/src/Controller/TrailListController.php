<?php

namespace App\Controller;

use App\Entity \User;
use App\Entity\Trails;
use App\Form\UploadType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


    /**
     * @Route("/admin", name="admin")
     */
class TrailListController extends AbstractController
{
    /**
     * @Route("/traillist", name="traillist")
     */
    public function trailList(Request $request, PaginatorInterface $paginator)
    {
        $repoUser = $this->getDoctrine()->getRepository(User::class);
        $users = $repoUser->findAll();

        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findAll();

               // Retrieve the entity manager of Doctrine
               $em = $this->getDoctrine()->getManager();
               // Get some repository of data, in our case we have an Appointments entity
               $trailsRepository = $em->getRepository(Trails::class);
               // Find all the data on the Appointments table, filter your query as you need
               $allotrailsQuery = $trailsRepository->createQueryBuilder('p')
                   ->getQuery();
               // Paginate the results of the query
               $trails = $paginator->paginate(
                   // Doctrine Query, not results
                   $allotrailsQuery,
                   // Define the page parameter
                   $request->query->getInt('page', 1),
                   // Items per page
                   10
               );

        return $this->render('admin/traillist.html.twig', [
            'controller_name' => 'TrailListController',
            'trails' => $trails,
            'users' => $users
        ]);

    }
    

    /**
     * @Route("/traillist/{id}/update", name="traillist_update")
     */
    public function trailUpdate(Request $request, int $id) {
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $em = $this->getDoctrine()->getManager();
  
        if($request->isXmlHttpRequest()) {
        //   $trail = $repo->findBy(['id' => $id]);
          $trail = $repo->findTrailById($id);
          $etat = $request->request->get('etat');
          $trail->setEnabled($etat);
          $em->flush();
        }
  
        return $this->redirectToRoute('admintraillist');
  
      }

    /**
     * @Route("/traillist/{id}/modifier", name="traillist_edit", methods={"GET","POST"})
     */
    public function edit($id, Request $request, KernelInterface $kernel)
    {
         //find id target edit with the repository 
         $repo = $this->getDoctrine()->getRepository(Trails::class);
         $trail = $repo->find($id);
 
 //Utilisation du composant Filesystem et  l'initialisé dans une variable 
 $filesystem = new Filesystem();
 //Recuperation des données initial dans le champs de la source de l'image
 $imageSrc = $trail->getImage();
 $gpxSrc = $trail->getGpx();
 //Récupération du répertoire racine de mon projet Symfony 
 $rootDir = $kernel->getProjectDir();
 $form = $this->createForm(UploadType::class, $trail);
 //Utilisation de la méthode handleRequest() pour détecter à quel moment le formulaire a été soumis.
 $form->handleRequest($request);
 //sinon on recuperer la données qui a été entré dans le champs 
 $file = $form->get('image')->getData();
 //sinon on recuperer la données qui a été entré dans le champs 
 $fileGpx = $form->get('gpx')->getData();
 
         // $form = $this->createForm(UploadType::class, $trail);
         // $form->handleRequest($request);
 
         if($form->isSubmitted() && $form->isValid()) {
 
                         //Si il n'y a pas déja de données dans la database.
                         if($form->get('image')->getData() !== null) {
                             //et si le champs du formulaire est pas égale a null ou n'est pas vide
                             if($imageSrc !== null && $imageSrc !== ""){
                                 //alors on supprime l'image initial
                                 $filesystem->remove([$rootDir.'/public'.$imageSrc]);
                             }
                                 $fileName = '/uploads/'.md5(uniqid()).'.'.$file->guessExtension();
                                 //ajout du fichier dans le dossier /public/uploads (chemain est configuré dans service.yaml) 
                                 $file->move($this->getParameter('upload_directory'), $fileName);
                                 $trail->setImage($fileName);
                         }
                             else{
                                 $trail->setImage($imageSrc);
                             } 
             
                      
                             if($form->get('gpx')->getData() !== null) {
                                 //et si le champs du formulaire est pas égale a null ou n'est pas vide
                                 if($gpxSrc !== null && $gpxSrc !== ""){
                                     //alors on supprime l'image initial
                                     $filesystem->remove([$rootDir.'/public'.$gpxSrc]);
                                 }
                                     // récupération du nom d'origine
                                //  $originalFilename = pathinfo($fileGpx->getClientOriginalName(), PATHINFO_FILENAME );
                                //  $trail->setGpxName($originalFilename);
                                     $fileNameGpx = '/gpx/'.md5(uniqid()).'.'.$fileGpx->guessExtension();
                                     //ajout du fichier dans le dossier /public/uploads (chemain est configuré dans service.yaml) 
                                     $fileGpx->move($this->getParameter('upload_gpx'), $fileNameGpx);;
                                     $trail->setGpx($fileNameGpx);
                             }
                                 else{
                                     $trail->setGpx($gpxSrc);
                                 } 

            //Send the data in database with doctrine
            $em = $this->getDoctrine()->getManager();
            $em->persist($trail);
            $em->flush();

            return $this->redirectToRoute('admintraillist');
        }

        return $this->render('user/editTrail.html.twig',[
            'form' => $form->createView(),
            'trails' => $trail,
        ]);
    }

    /**
     * @Route("/traillist/{id}/supprimer", name="traillist_delete")
     */
    public function delete(Request $request, Trails $trail, $id, KernelInterface $kernel)
    {
        $repository = $this->getDoctrine()->getRepository(Trails::class);
        $trail = $repository->find($id);
        $filesystem = new Filesystem();
        $gpxSrc = $trail->getGpx();
        $imageSrc = $trail->getImage();


         if ($gpxSrc == NULL && $imageSrc != NULL) {
            $rootDir = $kernel->getProjectDir();
            $filesystem->remove([$rootDir.'/public'.$imageSrc]);

        }

        if ($imageSrc == NULL && $gpxSrc != NULL ) {
            $rootDir = $kernel->getProjectDir();
            $filesystem->remove([$rootDir.'/public'.$gpxSrc]);
        }
        
        if ($imageSrc && $gpxSrc) {
        $rootDir = $kernel->getProjectDir();
        $filesystem->remove([$rootDir.'/public'.$imageSrc]);
        $filesystem->remove([$rootDir.'/public'.$gpxSrc]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($trail);
        $entityManager->flush();

    if ($imageSrc && $gpxSrc == NULL) {
        if ($this->isCsrfTokenValid('delete'.$trail->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trail);
            $entityManager->flush();
        }
    }



        // if ($this->isCsrfTokenValid('delete'.$trail->getId(), $request->request->get('_token'))) {
            $entityTrails = $this->getDoctrine()->getManager();
            $entityTrails->remove($trail);
            $entityTrails->flush();
        // }

        return $this->redirectToRoute('admintraillist');
    }

  

    }