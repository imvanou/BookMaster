<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'auth.login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // gestion erreur

        $error = $authenticationUtils->getLastAuthenticationError();

        // email saisi par le user

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: 'auth.login', name: 'Accueil')]
    public function logout(): void
    {
       
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
