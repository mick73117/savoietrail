<?php

namespace App\Controller;

use App\Entity\TrailsUser;
use App\Form\TrailsUserType;
use App\Repository\TrailsUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trails/user")
 */
class TrailsUserController extends AbstractController
{
    /**
     * @Route("/", name="trails_user_index", methods={"GET"})
     */
    public function index(TrailsUserRepository $trailsUserRepository): Response
    {
        return $this->render('trails_user/index.html.twig', [
            'trails_users' => $trailsUserRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="trails_user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $trailsUser = new TrailsUser();
        $form = $this->createForm(TrailsUserType::class, $trailsUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trailsUser);
            $entityManager->flush();

            return $this->redirectToRoute('trails_user_index');
        }

        return $this->render('trails_user/new.html.twig', [
            'trails_user' => $trailsUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trails_user_show", methods={"GET"})
     */
    public function show(TrailsUser $trailsUser): Response
    {
        return $this->render('trails_user/show.html.twig', [
            'trails_user' => $trailsUser,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="trails_user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TrailsUser $trailsUser): Response
    {
        $form = $this->createForm(TrailsUserType::class, $trailsUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trails_user_index');
        }

        return $this->render('trails_user/edit.html.twig', [
            'trails_user' => $trailsUser,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trails_user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TrailsUser $trailsUser): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trailsUser->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trailsUser);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trails_user_index');
    }
}
