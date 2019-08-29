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


        // Retrieve the entity manager of Doctrine
        $em = $this->getDoctrine()->getManager();
        // Get some repository of data, in our case we have an Appointments entity
        $trailsRepository = $em->getRepository(Trails::class);
        // Find all the data on the Appointments table, filter your query as you need
        $allotrailsQuery = $trailsRepository->createQueryBuilder('p')
            ->getQuery();
        // Paginate the results of the query
        $trails = $paginator->paginate(
            // Doctrine Query, not results
            $allotrailsQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            10
        );
    

        return $this->render('map/trails.html.twig', [
            'controller_name' => 'TrailController',
            'trails' => $trails,
        ]);
    }
    
    /**
     * @Route("/trails_info/{id}/", name="trails_info")
     */
    public function somewhere($id)
    {
        $entityAlbum = $this->getDoctrine()->getRepository(PhotoAlbum::class);
        $albums = $entityAlbum->findAll();
        $repo = $this->getDoctrine()->getRepository(Trails::class);
        $trails = $repo->findTrailById($id);
        // $trails = $repo->findAll();
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
