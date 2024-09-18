<?php

// src/Controller/HomeController.php

namespace App\Controller;

use App\Entity\Temoin; // Assurez-vous que l'entité Temoin existe bien
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupérer les témoignages approuvés
        $temoignages = $entityManager->getRepository(Temoin::class)->findBy(['approuve' => true]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'temoignages' => $temoignages,
        ]);
    }
}
