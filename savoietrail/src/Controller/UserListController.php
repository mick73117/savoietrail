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
     * @Route("/utilisateur", name="user")
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


