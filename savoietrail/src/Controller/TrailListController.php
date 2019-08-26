<?php

namespace App\Controller;

use App\Entity \User;
use App\Entity\Trails;
use App\Form\UploadType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


    /**
     * @Route("/admin", name="admin")
     */
class TrailListController extends AbstractController
{
    /**
     * @Route("/traillist", name="traillist")
     */
    public function trailList()
    {
      $repoUser = $this->getDoctrine()->getRepository(User::class);
      $users = $repoUser->findAll();
      // $users = $this->getUser();
      // dump($users);die;

      
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findAll();
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
     * @Route("/traillist/{id}/modifier", name="traillist_edit")
     */
    public function edit($id)
    {
        //find id target edit with the repository 
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trail = $repo->find($id);

        $form = $this->createForm(UploadType::class, $trail);
        // $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            //if form Image is submitted upload file, concatenation path.random name.extension file, and move in /public/uplaods (target config in service.yaml)
            $file = $form->get('image')->getData();
            $fileName = '/uploads/'.md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'), $fileName);
            $trail->setImage($fileName);

            $fileGpx = $form->get('gpx')->getData();
            $fileNameGpx = '/gpx/'.md5(uniqid()).'.'.$fileGpx->guessExtension();
            $fileGpx->move($this->getParameter('upload_gpx'), $fileNameGpx);
            $trail->setGpx($fileNameGpx);
            $trail->setUser($user);

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
     * @Route("/traillist/{id}/supprimer", name="traillist_delete")
     */
    public function delete(trails $trail)
    {
        // if ($this->isCsrfTokenValid('delete'.$trail->getId(), $request->request->get('_token'))) {
            $entityTrails = $this->getDoctrine()->getManager();
            $entityTrails->remove($trail);
            $entityTrails->flush();
        // }

        return $this->redirectToRoute('admintraillist');
    }

  

    }