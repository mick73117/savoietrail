<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trails;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


  
class MyTrailsController extends AbstractController
{
    /**
     * @Route("/mes_trails", name="mes_trails")
     */
    // public function test()
    // {
    //     $repo = $this->getDoctrine()->getRepository(Trails::class);
    //     $trail = $repo->findAll();
    //     return $this->render('partials/navtabs.html.twig', [
    //         'trails' => $trail,
    //     ]);
    // }
    public function index()
    {
        return $this->render('partials/navtabs.html.twig', [
            'controller_name' => 'MyTrailsController',
        ]);
    }

    // /**
    //  * @Route("/trails", name="trails")
    //  */
    // public function index()
    // {
    //     $repo = $this->getDoctrine()->getRepository(Trails::class);

    //     $trails = $repo->findAll();
    //     return $this->render('partials/navtabs.html.twig', [
    //         'controller_name' => 'MyTrailController',
    //         'trails' => $trails
    //     ]);
    // }

    // /**
    //  * @Route("/trails_info/{id}/", name="trails_info")
    //  */
    // public function somewhere($id)
    // {
    //     $repo = $this->getDoctrine()->getRepository(Trails::class);
    //     $trails = $repo->findTrailById($id);
    //     // $trails = $repo->findAll();
    //     return $this->render('partials/navtabs.html.twig', [
    //         'controller_name' => 'MyTrailController',
    //         'trails' => $trails,
    //     ]);
    // }

}
