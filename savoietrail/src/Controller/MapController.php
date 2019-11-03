<?php

namespace App\Controller;

use App\Entity\Trails;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MapController extends AbstractController
{
    /**
     * @Route("/carte", name="map")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findAll();
     
       foreach ($trails as $trail ) {
        $gpx = $repo->findBy(['gpx' => [$trail->getGpx()]]);
       }
        return $this->render('map/map.html.twig', [
            'controller_name' => 'TrailController',
            'trails' => $trail,
            'gpxs' => $gpx,

        ]);
    }
    
}