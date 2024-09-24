<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminSetupController extends AbstractController
{
    #[Route('/setup-admin', name: 'setup_admin')]
    public function setupAdmin(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setRoles(['ROLE_ADMIN']);

        $hashedPassword = $passwordHasher->hashPassword($admin, 'adminpassword');
        $admin->setPassword($hashedPassword);

        $entityManager->persist($admin);
        $entityManager->flush();

        return new Response('Administrateur créé avec succès !');
    }
}
