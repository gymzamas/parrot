<?php
// src/Controller/BaseController.php

namespace App\Controller;

use App\Entity\Horaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getHoraires()
    {
        return $this->entityManager->getRepository(Horaire::class)->findAll();
    }
}
