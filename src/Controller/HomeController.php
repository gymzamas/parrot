<?php

// src/Controller/HomeController.php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Vous pouvez ajouter d'autres logiques ici si nécessaire

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            // 'temoignages' retiré car l'entité Temoin a été supprimée
        ]);
    }
}
