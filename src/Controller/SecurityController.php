<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/", name="app_")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("logout", name="logout")
     * @throws Exception
     */
    public function logout()
    {
        throw new Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

//    /**
//     * @Route("/editer/mot-de-passe", name="edit_password", methods={"GET","POST"})
//     * @param Request $request
//     * @return Response
//     */
//    public function editPassword(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
//    {
//        $form = $this->createForm(EditPasswordType::class, $this->getUser());
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $passwordData = $form->getData()->getPassword();
//            $encodePassword = $passwordEncoder->encodePassword($this->getUser(), $passwordData);
//            $this->getUser()->setPassword($encodePassword);
//
//            $entityManager->flush();
//            $this->addFlash('succes', 'Votre mot de passe a bien été modifié!!');
//
//            return $this->redirectToRoute('app_profile_provider', [
//                'id' => $this->getUser()->getProvider()->getId(),
//            ]);
//        }
//
//        return $this->render('security/edit_password.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }
}
