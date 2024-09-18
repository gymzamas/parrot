<?php
// src/Controller/NosServiceController.php

namespace App\Controller;

use App\Entity\Service;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NosServiceController extends AbstractController
{
    #[Route('/nos-services', name: 'nos_services')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $services = $entityManager->getRepository(Service::class)->findAll();

        return $this->render('nos_service/index.html.twig', [
            'services' => $services,
        ]);
    }
}
