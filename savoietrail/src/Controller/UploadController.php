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
        //crée un objet de PhotoAlbum et initialise des données
        $album = new PhotoAlbum();
        //crée un objet de Trails et initialise des données
        $trail = new Trails();
        // cration du formulaire
        $form = $this->createForm(UploadType::class, $trail);
        $form->handleRequest($request);
        // récupération de l'utilisateur connecté
        $user = $this->getUser();
        //le formulaire GPX est soumis
        $fileGpx = $form->get('gpx')->getData();
        //le formulaire Image est soumis
        $file = $form->get('image')->getData();


        // si le formulaire est soumis et valide alors:
        if($form->isSubmitted() && $form->isValid()) {
            // if($file == NULL || $fileGpx == NULL) {
            //     return $this->$form->isDisabled();
            // }



            //la concaténation du fichier path.random name.extension 
            $fileName = '/uploads/'.md5(uniqid()).'.'.$file->guessExtension();
            //le déplacement dans / public / images (configuration cible dans service.yaml)
            $file->move($this->getParameter('upload_directory'), $fileName);
            //envoi des données de image dans trails
            $trail->setImage($fileName);


            //la concaténation du fichier path.random name.extension 
            $fileNameGpx = '/gpx/'.md5(uniqid()).'.'.$fileGpx->guessExtension();
            //le déplacement dans / public / gpx (configuration cible dans service.yaml)
            $fileGpx->move($this->getParameter('upload_gpx'), $fileNameGpx);
            //envoi des données de gpx dans trail
            $trail->setGpx($fileNameGpx);
            //envoi l'utilisateur connecté dans trail
            $trail->setUser($user);
            
            //le formulaire album est soumis
           $fileAlbums = $form->get('album')->getData();
           // boucle foreach sur la collection Album
           foreach ($fileAlbums as $fileAlbum) {
               //envoi des données d'album dans trail
               $fileAlbum->setTrails($trail);      
           }

           // récupérer l'EntityManager via $this->getDoctrine()
            $em = $this->getDoctrine()->getManager();
            //indique à Doctrine que je souhaite enregistrer
            $em->persist($trail);
            // exécute les requêtes
            $em->flush();

            return $this->redirectToRoute('trails');

        }

        //lier le controller au template ou l'on souhaite le rendu
        return $this->render('import/addTrail.html.twig', [
            'controller_name' => 'UploadController',
            // Méthode pour construire un objet avec la représentation visuelle du formulaire
            'form' => $form->createView(),
            // définition du contexte en récupérant les id du trail et de l'utilisateur pour lier les données
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