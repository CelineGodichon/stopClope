<?php

namespace App\Controller;

use App\Entity\Cigarette;
use App\Form\CigaretteType;
use App\Repository\CigaretteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cigarette")
 */
class CigaretteController extends AbstractController
{
    /**
     * @Route("/", name="cigarette_index", methods={"GET"})
     */
    public function index(CigaretteRepository $cigaretteRepository): Response
    {
        return $this->render('cigarette/index.html.twig', [
            'cigarettes' => $cigaretteRepository->findAll(),
        ]);
    }



    /**
     * @Route("/{id}", name="cigarette_show", methods={"GET"})
     */
    public function show(Cigarette $cigarette): Response
    {
        return $this->render('cigarette/show.html.twig', [
            'cigarette' => $cigarette,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cigarette_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cigarette $cigarette): Response
    {
        $form = $this->createForm(CigaretteType::class, $cigarette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cigarette_index');
        }

        return $this->render('cigarette/edit.html.twig', [
            'cigarette' => $cigarette,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cigarette_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Cigarette $cigarette): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cigarette->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cigarette);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cigarette_index');
    }
}
