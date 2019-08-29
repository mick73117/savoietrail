<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;


    /**
     * @Route("/admin", name="admin")
     */
class UserListController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="user")
     */
    public function userList(Request $request, PaginatorInterface $paginator)
    {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAll();

               // Retrieve the entity manager of Doctrine
               $em = $this->getDoctrine()->getManager();
               // Get some repository of data, in our case we have an Appointments entity
               $usersRepository = $em->getRepository(User::class);
               // Find all the data on the Appointments table, filter your query as you need
               $allousersQuery = $usersRepository->createQueryBuilder('p')
                   ->getQuery();
               // Paginate the results of the query
               $users = $paginator->paginate(
                   // Doctrine Query, not results
                   $allousersQuery,
                   // Define the page parameter
                   $request->query->getInt('page', 1),
                   // Items per page
                   10
               );

        return $this->render('admin/userlist.html.twig', [
            'controller_name' => 'UserListController',
            'users' => $users
        ]);
    }

    /**
     * @Route("/utilisateur/{id}/update", name="user_update")
     */
    public function userUpdate(Request $request, int $id) {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $em = $this->getDoctrine()->getManager();
  
        if($request->isXmlHttpRequest()) {
          $user = $repo->findUserById($id);
          $etat = $request->request->get('etat');
          $user->setEnabled($etat);
          $em->flush();
        }
  
        return $this->redirectToRoute('adminuser');
  
      }

    /**
     * @Route("/utilisateur/{id}/modifier", name="user_edit")
     */
    public function userEdit(Request $request, int $id) {
      $repo = $this->getDoctrine()->getRepository(User::class);
      $em = $this->getDoctrine()->getManager();

      if($request->isXmlHttpRequest()) {
        $user = $repo->findUserById($id);
        $etat = $request->request->get('etat');
        $user->setEnabled($etat);
        $em->flush();
      }

      return $this->redirectToRoute('adminuser');

    }

    /**
     * @Route("/utilisateur/{id}/supprimer", name="user_delete")
     */
    public function userDelete(user $user)
    {
        // if ($this->isCsrfTokenValid('delete'.$trail->getId(), $request->request->get('_token'))) {
            $entityTrails = $this->getDoctrine()->getManager();
            $entityTrails->remove($trail);
            $entityTrails->flush();
        // }

        return $this->redirectToRoute('adminuser');
    }


}


