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
    

class UploadAlbumController extends AbstractController
{
    /**
     * @Route("add_trail_album/{id}", name="add_album")
     */
    public function albumForm(Request $request , ObjectManager $em, int $id)
    {
        $album = new PhotoAlbum();
                 
        $repo = $this->getDoctrine()->getRepository(Trails::class);
 
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);
        $trail = $repo->findTrailById($id);
        if($form->isSubmitted() && $form->isValid()) {
             //if form Image is submitted upload file, concatenation path.random name.extension file, and move in /public/uplaods (target config in service.yaml)
             $file = $form->get('album')->getData();
             $fileName = '/album/'.uniqid().'.'.$file->guessExtension();
             $file->move($this->getParameter('upload_album'), $fileName);
             $album->setAlbum($fileName);
 
             $album->setTrails($trail);
 
             $em = $this->getDoctrine()->getManager();
             $em->persist($album);
             $em->flush();
 
             return $this->redirectToRoute('mes_trails');
        }
 
        return $this->render('import/addAlbum.html.twig', [
            'controller_name' => 'UploadController',
            'form' => $form->createView(),
            'album' => $album,
        ]);
 
    }

}