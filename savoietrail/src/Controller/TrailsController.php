<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trails;
use App\Entity\PhotoAlbum;
use App\Entity\TrailsUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TrailsController extends AbstractController
{
    /**
     * @Route("/trails", name="trails")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findAll();

        return $this->render('map/trails.html.twig', [
            'controller_name' => 'TrailController',
            'trails' => $trails
        ]);
    }
    
    /**
     * @Route("/trails_info/{id}/", name="trails_info")
     */
    public function somewhere($id)
    {
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findTrailById($id);
        // $trails = $repo->findAll();
        return $this->render('map/trailsinfo.html.twig', [
            'controller_name' => 'TrailController',
            'trails' => $trails,
        ]);
        
    }




//metre en favori

    // /**
    //  * @Route("/trails", name="trails")
    //  */
    // public function trailList()
    // {
    //     $repo = $this->getDoctrine()->getRepository(Trails::class, User::class);
    //     // $favorite = $repo->findAll();
    //     $favorite = $repo->findTrailById($id);
    //     $favorite = $repo->findUserById($id);
    //     return $this->render('admin/trails.html.twig', [
    //         'controller_name' => 'TrailsController',
    //         'favori' => $favorite
    //     ]);
    // }



    //  /**
    //  * @Route("/trails/{id}/update", name="trails_update")
    //  */
    // public function trailfavoriteUpdate(Request $request, int $id) {
    //     $repo = $this->getDoctrine()->getRepository(TrailsUser::class);
    //     $em = $this->getDoctrine()->getManager();
  
    //     if($request->isXmlHttpRequest()) {
    //     $favorite = $repo->findAll(['id' => $id]);
    //     //   $favorite = $repo->findAll($id);
    //       $etat = $request->request->get('etat');
    //       $favorite->setFavori($etat);
    //       $em->flush();
    //     }
    //     return $this->redirectToRoute('admintraillist');
  
    //   }


















    //   /**
    //  * @Route("/trails", name="trails")
    //  */
    // public function trailList()
    // {
    //     $repo = $this->getDoctrine()->getRepository(Trails::class);
    //     $trails = $repo->findAll();
    //     return $this->render('admin/trail.html.twig', [
    //         'controller_name' => 'TrailController',
    //         'trails' => $trails
    //     ]);
    // }

    // /**
    //  * @Route("/trails/{id}/update", name="trails_update")
    //  */
    // public function trailUpdate(Request $request, int $id) {
    //     $repo = $this->getDoctrine()->getRepository(Trails::class);
    //     $em = $this->getDoctrine()->getManager();
  
    //     if($request->isXmlHttpRequest()) {
    //     //   $trail = $repo->findBy(['id' => $id]);
    //       $trail = $repo->findTrailById($id);
    //       $etat = $request->request->get('etat');
    //       $trail->setEnabled($etat);
    //       $em->flush();
    //     }
  
    //     return $this->redirectToRoute('admintraillist');
  
    //   }


    
}
