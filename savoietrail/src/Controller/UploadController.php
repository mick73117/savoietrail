<?php

namespace App\Controller;

use App\Entity\Trails;
use App\Form\AlbumType;
use App\Form\UploadType;
use App\Entity\PhotoAlbum;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class UploadController extends AbstractController
{
    /**
     * @Route("/add_trail", name="add_trail")
     */
    public function uploadTrail(Request $request , ObjectManager $em)
    {
        $trail = new Trails();
        $form = $this->createForm(UploadType::class, $trail);
        $form->handleRequest($request);

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


            $em = $this->getDoctrine()->getManager();
            $em->persist($trail);
            // $em->persist($gpx);
            $em->flush();

             return $this->redirectToRoute('mes_trails');
        }

        return $this->render('import/addTrail.html.twig', [
            'controller_name' => 'UploadController',
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/add_album", name="add_album")
     */
   public function albumForm(Request $request , ObjectManager $em)
   {
       $album = new PhotoAlbum();
                   
       $form = $this->createForm(AlbumType::class, $album);
       $form->handleRequest($request);

       if($form->isSubmitted() && $form->isValid()) {
            //if form Image is submitted upload file, concatenation path.random name.extension file, and move in /public/uplaods (target config in service.yaml)
            $file = $form->get('album')->getData();
            $fileName = '/album/'.uniqid().'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_album'), $fileName);
            $album->setAlbum($fileName);


           $em = $this->getDoctrine()->getManager();
           $em->persist($album);
           $em->flush();

           return $this->redirectToRoute('mes_trails');
       }

       return $this->render('import/addTrail.html.twig', [
           'controller_name' => 'UploadController',
           'form' => $form->createView(),
       ]);

   }
    
}