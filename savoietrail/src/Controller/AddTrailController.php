<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AddTrailController extends AbstractController
{
    /**
     * @Route("/add_trail", name="add_trail")
     */
    public function index()
    {
        return $this->render('import/addTrail.html.twig', [
            'controller_name' => 'AddTrailController',
        ]);
    }
    
}