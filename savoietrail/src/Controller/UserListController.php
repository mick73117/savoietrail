<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;


    /**
     * @Route("/admin", name="admin")
     */
class UserListController extends AbstractController
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function userList()
    {
        $repo = $this->getDoctrine()->getRepository(User::class);

        $users = $repo->findAll();

        return $this->render('admin/userlist.html.twig', [
            'controller_name' => 'UserListController',
            'users' => $users
        ]);
    }

    /**
     * @Route("/utilisateur/{id}/update", name="utilisateur_update")
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
  
        return $this->redirectToRoute('adminutilisateur');
  
      }


}


