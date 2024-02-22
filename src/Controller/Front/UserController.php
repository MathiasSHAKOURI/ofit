<?php

namespace App\Controller\Front;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/login", name="app_front_user_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_front_user_profile');
        };
        
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('front/security/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
    * @Route("/logout", name="app_front_user_logout")
    */
    public function logout(): void
    {
    }

    /**
     * @Route("/mon-profil", name="app_front_user_profile")
     */
    public function userProfileShow(): Response
    {
        return $this->render('front/security/show.html.twig', [
            'user' => $this->getUser(),
        ]);
    }
}
