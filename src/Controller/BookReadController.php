<?php


namespace App\Controller;

use App\Entity\BookRead;
use App\Form\BookReadFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookReadController extends AbstractController
{
    #[Route('/book/read/add', name: 'form', methods: ['GET', 'POST'])]
    public function add(Request $request, EntityManagerInterface $entityManager): Response
    {
        $bookRead = new BookRead();
        $form = $this->createForm(BookReadFormType::class, $bookRead);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
   
            $bookRead->setCreatedAt(new \DateTime());
            $bookRead->setUpdatedAt(new \DateTime());


            $entityManager->persist($bookRead);
            $entityManager->flush();

      
            $this->addFlash('success', 'Lecture enregistré avec succés');

            return $this->redirectToRoute('Accueil'); 
        }

        return $this->render('modals/book.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
