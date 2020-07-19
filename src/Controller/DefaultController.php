<?php

namespace App\Controller;

use App\Entity\Cigarette;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/{id}", name="homepage")
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
     * @Route(name="smokingButton")
     * @param User $user
     * @param Cigarette $cigarette
     * @return Response
     */
    public function smokingButton(User $user, Cigarette $cigarette)
    {
        $cigarette = new Cigarette;

        return $this->render('homepage.html.twig', [
            'user' => $user,
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
