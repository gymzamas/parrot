<?php
// src/Controller/TemoignageController.php

namespace App\Controller;

use App\Form\TemoignageType;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Exception\FirebaseException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TemoignageController extends AbstractController
{
    private $firestore;

    public function __construct(Factory $firebaseFactory)
    {
        // Connexion à la base Firestore via Firebase
        $this->firestore = $firebaseFactory->createFirestore()->database();
    }

    #[Route('/temoignage', name: 'app_temoignage_index')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(TemoignageType::class);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, on ajoute le témoignage à Firebase
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            try {
                // Ajout du témoignage à Firestore
                $this->firestore->collection('temoignages')->add([
                    'nom' => $data['nom'],
                    'commentaire' => $data['commentaire'],
                    'note' => $data['note'],
                    'approuve' => false // Témoignage non approuvé par défaut
                ]);
                $this->addFlash('success', 'Votre témoignage a bien été soumis pour modération.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de l\'envoi du témoignage.');
            }

            return $this->redirectToRoute('app_temoignage_index');
        }

        // Récupérer les témoignages approuvés depuis Firestore
        $temoignagesSnapshot = $this->firestore->collection('temoignages')->where('approuve', '=', true)->documents();
        $temoignages = [];
        foreach ($temoignagesSnapshot as $temoignage) {
            $temoignages[] = $temoignage->data();
        }

        return $this->render('temoignage/index.html.twig', [
            'form' => $form->createView(),
            'temoignages' => $temoignages,
        ]);
    }

    #[Route('/temoignage/moderation', name: 'app_temoignage_moderation')]
    public function moderation(): Response
    {
        // Récupérer les témoignages en attente d'approbation
        $temoignagesSnapshot = $this->firestore->collection('temoignages')->where('approuve', '=', false)->documents();
        $temoignages = [];
        foreach ($temoignagesSnapshot as $temoignage) {
            $temoignages[] = $temoignage->data();
        }

        return $this->render('temoignage/moderation.html.twig', [
            'temoignages' => $temoignages,
        ]);
    }

    #[Route('/temoignage/{id}/approuver', name: 'app_temoignage_approuver')]
    public function approuver(string $id): Response
    {
        // Marquer le témoignage comme approuvé
        try {
            $temoignage = $this->firestore->collection('temoignages')->document($id);
            $temoignage->update([
                ['path' => 'approuve', 'value' => true]
            ]);
            $this->addFlash('success', 'Le témoignage a été approuvé avec succès.');
        } catch (\Exception $e) {
            $this->addFlash('error', 'Erreur lors de l\'approbation du témoignage.');
        }

        return $this->redirectToRoute('app_temoignage_moderation');
    }
}
