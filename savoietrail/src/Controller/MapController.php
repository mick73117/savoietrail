<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    /**
     * @Route("/carte", name="map")
     */
    public function index()
    {
        return $this->render('map/map.html.twig', [
            'controller_name' => 'TrailController',
        ]);
    }
    
}