<?php

namespace App\Controller;

use App\Entity\Cigarette;
use App\Entity\User;
use App\Form\CigaretteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/homepage/{id}", name="homepage")
     * @param User $user
     * @return Response
     */
    public function index(User $user)
    {
        return $this->render('homepage.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/new", name="cigarette_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function newCigarette(Request $request): Response
    {
        $cigarette = new Cigarette();
        $form = $this->createForm(CigaretteType::class, $cigarette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cigarette);
            $entityManager->flush();

            return $this->redirectToRoute('homepage', [
                'user' => $this->getUser()
            ]);
        }

        return $this->render('cigarette/new.html.twig', [
            'cigarette' => $cigarette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/boardtable", name="boardtable")
     */
    public function boardtable()
    {
        return $this->render('boardtable.html.twig');
    }
}
