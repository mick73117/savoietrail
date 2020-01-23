<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trails;
use App\Entity\PhotoAlbum;
use App\Entity\TrailsUser;
use App\Form\UploadType;
use Symfony\Component\DomCrawler\Crawler;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


  
class MyTrailsController extends AbstractController
{
    // /**
    //  * @Route("/mes_trails", name="mes_trails")
    //  */
    // public function test()
    // {
    //     $repo = $this->getDoctrine()->getRepository(Trails::class);
    //     $trail = $repo->findAll();
    //     return $this->render('partials/navtabs.html.twig', [
    //         'trails' => $trail,
    //     ]);
    // }
    // public function index()
    // {
    //     return $this->render('partials/navtabs.html.twig', [
    //         'controller_name' => 'MyTrailsController',
    //     ]);
    // }
  

    /**
     * @Route("/", name="mes_trails")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $user = $this->getUser();
        $trails = $repo->findBy(["user" => $user]);



        return $this->render('partials/navtabs.html.twig', [
            'controller_name' => 'MyTrailsController',
            'trails' => $trails,
            // 'id' => $user->getId()
        ]);
    }
 

    // /**
    //  * @Route("/{id}/favoris", name="favoris")
    //  */
    // public function trailUpdate(Request $request, int $id) {
    //     $repo = $this->getDoctrine()->getRepository(Trails::class);
    //     $trails = $repo->findTrailById($id);
    //     $repo2 = $this->getDoctrine()->getRepository(TrailsUser::class);
    //     $favori = $repo2->setFavori($id);
    //     $entityManager = $this->getDoctrine()->getManager();
    //     // $trailId = $this->getTrails();
    //     // $favori = $repo2->fingAll();
    //     // $idFavori = $repo2->findById($id);
    //     // $idTrail = $repo->find($id);
    //     // $id = $_REQUEST['id'];
    // //    $idTrail = $repo->findBy(['id' => $id]);
    // //    var_dump($id);die;
    //       $id = $trails->getId();
    //       $em2->setFavori($id);
    //       $em2->flush();
        
  
    //     return $this->redirectToRoute('trail');
  
    //   }

    /**
     * @Route("/info/{id}/", name="mes_trails_info")
     */
    public function somewhere($id)
    {
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findTrailById($id);

        $entityAlbum = $this->getDoctrine()->getRepository(PhotoAlbum::class);
        $albums = $entityAlbum->findBy(['trails' => $trails]);
        
        return $this->render('user/trailinfo.html.twig', [
            'controller_name' => 'MyTrailController',
            'trails' => $trails,
            'albums' => $albums,
        ]);
    }

    /**
     * @Route("/trail/{id}/modifier", name="trail_edit")
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
                                // $originalFilename = pathinfo($fileGpx->getClientOriginalName(), PATHINFO_FILENAME );
                                // $trail->setGpxName($originalFilename);
                                    $fileNameGpx = '/gpx/'.md5(uniqid()).'.'.$fileGpx->guessExtension();
                                    //ajout du fichier dans le dossier /public/uploads (chemain est configuré dans service.yaml) 
                                    $fileGpx->move($this->getParameter('upload_gpx'), $fileNameGpx);;
                                    $trail->setGpx($fileNameGpx);
                            }
                                else{
                                    $trail->setGpx($gpxSrc);
                                } 
                            
            //if form Image is submitted upload file, concatenation path.random name.extension file, and move in /public/uplaods (target config in service.yaml)
            // $file = $form->get('image')->getData();
            // $fileName = '/uploads/'.md5(uniqid()).'.'.$file->guessExtension();
            // $file->move($this->getParameter('upload_directory'), $fileName);
            // $trail->setImage($fileName);

            // // $fileGpx = $form->get('gpx')->getData();
            // $fileNameGpx = '/gpx/'.md5(uniqid()).'.'.$fileGpx->guessExtension();
            // $fileGpx->move($this->getParameter('upload_gpx'), $fileNameGpx);
            // $trail->setGpx($fileNameGpx);
            // $trail->setUser($user);

            //Send the data in database with doctrine
            $em = $this->getDoctrine()->getManager();
            $em->persist($trail);
            $em->flush();

            // return $this->redirectToRoute('mes_trail');
        }

        return $this->render('user/editTrail.html.twig',[
            'form' => $form->createView(),
            'trails' => $trail,
        ]);
    }

    /**
     * @Route("/trail/{id}/supprimer", name="trail_delete")
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
            // $entityTrails = $this->getDoctrine()->getManager();
            // $entityTrails->remove($trail);
            // $entityTrails->flush();
        // }

        return $this->redirectToRoute('trails');
    }

}

