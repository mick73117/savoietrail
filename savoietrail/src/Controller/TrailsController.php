<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Trails;
use App\Entity\PhotoAlbum;
use App\Entity\TrailsUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class TrailsController extends AbstractController
{
    /**
     * @Route("/trails", name="trails")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {

        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findAll();

        $trailsR = array_reverse($trails, true);
        $pagination = $paginator->paginate( $trailsR,
        $request->query->getInt('page', 1),
        9
    );
 

        return $this->render('map/trails.html.twig', [
            'controller_name' => 'TrailController',
            'pagination' => $pagination,
        ]);
    }
    
    /**
     * @Route("/trails_info/{id}/", name="trails_info")
     */
    public function somewhere($id)
    {

        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findTrailById($id);

        $entityAlbum = $this->getDoctrine()->getRepository(PhotoAlbum::class);
        
        $albums = $entityAlbum->findBy(['trails' => $trails]);
        return $this->render('map/trailsinfo.html.twig', [
            'controller_name' => 'TrailController',
            'trails' => $trails,
            'albums' => $albums,
        ]);
        
    }



    




//metre en favori

    // /**
    //  * @Route("/trails", name="trails")
    //  */
    // public function trailList()
    // {
    //     $user = $this->getUser();
    //     $repo = $this->getDoctrine()->getRepository(Trails::class);
    //     // $favorite = $repo->findAll();
    //     // $favorite = $repo->findTrailBy(["user" => $user]);
    //     $favorite = $repo->findBy(["user" => $user]);
    //     return $this->render('map/trails.html.twig', [
    //         'controller_name' => 'TrailsController',
    //         'favori' => $favorite
    //     ]);
 
    // }



     /**
     * @Route("/trails/{id}/update", name="trails_update")
     */
    public function trailfavoriteUpdate(Request $request, int $id) {
        $repo = $this->getDoctrine()->getRepository(TrailsUser::class);
        $em = $this->getDoctrine()->getManager();
  
        if($request->isXmlHttpRequest()) {
        $favorite = $repo->findAll(['id' => $id]);
        //   $favorite = $repo->findAll($id);
          $etat = $request->request->get('etat');
          $favorite->setFavori($etat);
          $em->flush();
        }
        return $this->redirectToRoute('admintraillist');
  
      }




  


    
}
