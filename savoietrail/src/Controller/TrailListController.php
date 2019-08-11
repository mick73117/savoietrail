<?php

namespace App\Controller;

use App\Entity\Trails;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


    /**
     * @Route("/admin", name="admin")
     */
class TrailListController extends AbstractController
{
    /**
     * @Route("/traillist", name="traillist")
     */
    public function trailList()
    {
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findAll();
        return $this->render('admin/traillist.html.twig', [
            'controller_name' => 'TrailListController',
            'trails' => $trails
        ]);
    }

    /**
     * @Route("/traillist/{id}/update", name="traillist_update")
     */
    public function trailUpdate(Request $request, int $id) {
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $em = $this->getDoctrine()->getManager();
  
        if($request->isXmlHttpRequest()) {
        //   $trail = $repo->findBy(['id' => $id]);
          $trail = $repo->findTrailById($id);
          $etat = $request->request->get('etat');
          $trail->setEnabled($etat);
          $em->flush();
        }
  
        return $this->redirectToRoute('admintraillist');
  
      }

  

    }