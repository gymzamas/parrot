<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Kreait\Firebase\Firestore;

class CommentController extends AbstractController
{
    #[Route('/comment/new', name: 'comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Firestore $firestore): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Persister l'avis dans la base de données pour validation
            $entityManager->persist($comment);
            $entityManager->flush();

            // Ajouter l'avis dans Firestore après validation
            $firestore->database()
                ->collection('comments')
                ->add([
                    'name' => $comment->getName(),
                    'content' => $comment->getContent(),
                    'rating' => $comment->getRating(),
                    'approved' => false, // L'avis doit être approuvé par un employé
                ]);

            $this->addFlash('success', 'Votre commentaire a été soumis et sera validé.');
            return $this->redirectToRoute('comments'); // Rediriger vers la page des commentaires
        }

        return $this->render('comment/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
