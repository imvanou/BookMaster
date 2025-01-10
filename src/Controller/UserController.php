<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

//Méthode pour l'ajout d'un utilisateur dans la BDD + système de vérification

class UserController extends AbstractController
{
    #[Route('/register', name: 'auth.register', methods: ['GET', 'POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): Response {
        if ($request->isMethod('POST')) {
            
            //rêquete

            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $passwordConfirmation = $request->request->get('password_confirmation');
    
            // Vérification du mdp

            if ($password !== $passwordConfirmation) {
                $this->addFlash('error', 'Les mots de passe ne correspondent pas.');
                return $this->redirectToRoute('auth.register');
            }

             // Longueur mdp minimum 8

            if (strlen($password) < 8) {
            $this->addFlash('error', 'Le mot de passe doit contenir au moins 8 caractères.');
            return $this->redirectToRoute('auth.register');
            }

            // Validation du mail correct

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->addFlash('error', 'L\'email est invalide.');
                return $this->redirectToRoute('auth.register');
            }
    
            // Validation des champs

            if (empty($email) || empty($password)) {
                $this->addFlash('error', 'Tous les champs sont obligatoires.');
                return $this->redirectToRoute('auth.register');
            }
    
            // Création d'un user

            $user = new User();
            $user->setEmail($email);
            $hashedPassword = $passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
    
            $entityManager->persist($user);
            $entityManager->flush();

            $user_id = $user->getId();
    
            // Message de succès
            
            $this->addFlash('success', "Votre compte a été créé avec succès !");
            return $this->redirectToRoute('auth.login');
        }
    
        return $this->render('auth/register.html.twig');
    }
    

    }

