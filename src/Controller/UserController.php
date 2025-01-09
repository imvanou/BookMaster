<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

//Méthode pour l'ajout d'un utilisateur dans la BDD

class UserController extends AbstractController
{
    #[Route('/register', name: 'register', methods:['GET','POST'])
    ]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
