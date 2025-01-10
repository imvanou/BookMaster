<?php

namespace App\Controller;

use App\Entity\BookRead;
use App\Form\BookReadFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookReadController extends AbstractController
{
   
    #[Route('/book-read/new', name: 'book_read_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
       
        $bookRead = new BookRead();

        $form = $this->createForm(BookReadFormType::class, $bookRead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        
            $bookRead->setCreatedAt(new \DateTime());
            $bookRead->setUpdatedAt(new \DateTime());

            $entityManager->persist($bookRead);
            $entityManager->flush();

           
            return $this->redirectToRoute('app.home'); 
        }

        // Retourner le formulaire au format Twig
        return $this->render('book_read/book.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

