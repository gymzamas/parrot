<?php

// src/Controller/VoitureOccasionController.php

namespace App\Controller;

use App\Entity\VoitureOccasion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/{id}', name: 'app_voiture_occasion_show', methods: ['GET'])]
    public function show(VoitureOccasion $voitureOccasion): Response
    {
        return $this->render('voiture_occasion/show.html.twig', [
            'voiture' => $voitureOccasion,
        ]);
    }
}
