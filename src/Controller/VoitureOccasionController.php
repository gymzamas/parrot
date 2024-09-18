<?php

namespace App\Controller;

use App\Entity\VoitureOccasion;
use App\Form\VoitureOccasionType;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/voiture/occasion')]
class VoitureOccasionController extends AbstractController
{
    #[Route('/', name: 'app_voiture_occasion_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $voitures = $entityManager->getRepository(VoitureOccasion::class)->findAll();

        return $this->render('voiture_occasion/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    #[Route('/new', name: 'app_voiture_occasion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $voiture = new VoitureOccasion();
        $form = $this->createForm(VoitureOccasionType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($voiture);
            $entityManager->flush();

            // Ajout d'un message flash après validation
            $this->addFlash('success', 'La voiture a été ajoutée avec succès.');

            // Redirection vers la liste des voitures après ajout
            return $this->redirectToRoute('app_voiture_occasion_index');
        }

        return $this->render('voiture_occasion/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_voiture_occasion_show', methods: ['GET', 'POST'])]
    public function show(Request $request, VoitureOccasion $voitureOccasion): Response
    {
        // Création du formulaire de contact pour la voiture
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Logique pour traiter le formulaire de contact (envoi d'email ou stockage)
            
            // Ajout d'un message flash après soumission du formulaire de contact
            $this->addFlash('success', 'Votre message a été envoyé avec succès.');

            // Redirection pour éviter la double soumission du formulaire
            return $this->redirectToRoute('app_voiture_occasion_show', ['id' => $voitureOccasion->getId()]);
        }

        return $this->render('voiture_occasion/show.html.twig', [
            'voiture' => $voitureOccasion,
            'form' => $form->createView(),
        ]);
    }
}
