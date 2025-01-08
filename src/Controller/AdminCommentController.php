<?php

namespace App\Controller;

use Kreait\Firebase\Firestore;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminCommentController extends AbstractController
{
    #[Route('/comments', name: 'admin_comments')]
    public function adminComments(Firestore $firestore): Response
    {
        // Récupérer les commentaires non approuvés depuis Firestore
        $comments = $firestore->database()
            ->collection('comments')
            ->where('approved', '=', false)
            ->documents();

        // Rendre la vue avec les commentaires à valider
        return $this->render('admin/comments.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/comment/{id}/approve', name: 'admin_approve_comment')]
    public function approveComment(string $id, Firestore $firestore): Response
    {
        // Récupérer le commentaire depuis Firestore
        $comment = $firestore->database()->collection('comments')->document($id)->snapshot();

        if (!$comment->exists()) {
            $this->addFlash('error', 'Le commentaire n\'existe pas.');
            return $this->redirectToRoute('admin_comments');
        }

        // Approuver le commentaire
        $firestore->database()->collection('comments')->document($id)->update([
            ['path' => 'approved', 'value' => true]
        ]);

        $this->addFlash('success', 'Commentaire approuvé avec succès.');
        return $this->redirectToRoute('admin_comments');
    }

    #[Route('/comment/{id}/reject', name: 'admin_reject_comment')]
    public function rejectComment(string $id, Firestore $firestore): Response
    {
        // Vérifier si le commentaire existe avant de le supprimer
        $comment = $firestore->database()->collection('comments')->document($id)->snapshot();

        if (!$comment->exists()) {
            $this->addFlash('error', 'Le commentaire n\'existe pas.');
            return $this->redirectToRoute('admin_comments');
        }

        // Supprimer le commentaire
        $firestore->database()->collection('comments')->document($id)->delete();

        $this->addFlash('success', 'Commentaire rejeté avec succès.');
        return $this->redirectToRoute('admin_comments');
    }
}
