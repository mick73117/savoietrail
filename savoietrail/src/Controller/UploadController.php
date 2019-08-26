<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\File\Exception\FileException ;
use Symfony\Component\HttpFoundation\File\UploadedFile ;
use App\Entity\Trails;
use App\Entity\User;
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
        $album = new PhotoAlbum();
        $trail = new Trails();
        $form = $this->createForm(UploadType::class, $trail);
        $form->handleRequest($request);
        $user = $this->getUser();

    

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

            // TODO boucle for sur ta collection $trail->getAlbum()  
           $fileAlbums = $form->get('album')->getData();
           foreach ($fileAlbums as $fileAlbum) {
               $fileAlbum->setTrails($trail);      
             //$trail->getAlbum($fileAlbum);
           }

            $em = $this->getDoctrine()->getManager();
            $em->persist($trail);
            $em->flush();

        }

        return $this->render('import/addTrail.html.twig', [
            'controller_name' => 'UploadController',
            'form' => $form->createView(),
            'id' => $trail->getId(),
            'id' => $user->getId()
        ]);
        }

//   /**
//      * @Route("add_trail_album/{id}", name="add_album")
//      */
//     public function albumForm(Request $request , ObjectManager $em, int $id)
//     {
//         $album = new PhotoAlbum();
                 
//         $repo = $this->getDoctrine()->getRepository(Trails::class);
 
//         $form = $this->createForm(AlbumType::class, $album);
//         $form->handleRequest($request);
//         $trail = $repo->findTrailById($id);
//         if($form->isSubmitted() && $form->isValid()) {
//              //if form Image is submitted upload file, concatenation path.random name.extension file, and move in /public/uplaods (target config in service.yaml)
//              $fileAlbum = $form->get('album')->getData();
//             //  dump($fileAlbum);
//             //  die;
//              $fileNameAlbum = '/album/'.uniqid().'.'.$fileAlbum->guessExtension();
//              $fileAlbum->move($this->getParameter('upload_album'), $fileNameAlbum);
//              $album->setAlbum($fileNameAlbum);
 
//              $album->setTrails($trail);
 
//              $em = $this->getDoctrine()->getManager();
//              $em->persist($album);
//              $em->flush();
 
//              return $this->redirectToRoute('mes_trails');
//         }
 
//         return $this->render('import/addAlbum.html.twig', [
//             'controller_name' => 'UploadController',
//             'form' => $form->createView(),
//             'album' => $album,
//         ]);
 
    // }

    
    


    
}