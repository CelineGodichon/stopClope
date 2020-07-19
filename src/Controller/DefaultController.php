<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('homepage.html.twig');
    }

    /**
     * @Route("/admin/boardtable", name="boardtable")
     */
    public function boardtable()
    {
        return $this->render('boardtable.html.twig');
    }
}