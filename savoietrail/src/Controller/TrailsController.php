<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TrailsController extends AbstractController
{
    /**
     * @Route("/trails", name="trails")
     */
    public function index()
    {
        return $this->render('map/trails.html.twig', [
            'controller_name' => 'TrailController',
        ]);
    }
    
}
