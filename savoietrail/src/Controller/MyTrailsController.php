<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trails;
use App\Form\UploadType;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Routing\Annotation\Route;
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
    public function index()
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

    /**
     * @Route("/info/{id}/", name="mes_trails_info")
     */
    public function somewhere($id)
    {
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findTrailById($id);
        return $this->render('user/trailinfo.html.twig', [
            'controller_name' => 'MyTrailController',
            'trails' => $trails,
        ]);
    }

    /**
     * @Route("/trail/{id}/modifier", name="trail_edit")
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

            return $this->redirectToRoute('mes_trail');
        }

        return $this->render('user/aditTrail.html.twig',[
            'form' => $form->createView(),
            'trails' => $trail,
        ]);
    }

    /**
     * @Route("/trail/{id}/supprimer", name="trail_delete")
     */
    public function delete(trails $trail)
    {
        // if ($this->isCsrfTokenValid('delete'.$trail->getId(), $request->request->get('_token'))) {
            $entityTrails = $this->getDoctrine()->getManager();
            $entityTrails->remove($trail);
            $entityTrails->flush();
        // }

        return $this->redirectToRoute('mes_trails');
    }

}

