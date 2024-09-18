<?php

// src/Controller/Admin/DashboardController.php

namespace App\Controller\Admin;

use App\Entity\Employe;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Génère une URL pour le CRUD Utilisateur dans le dashboard
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        $url = $adminUrlGenerator->setController(UtilisateurCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Employés', 'fas fa-user', Employe::class); // Lien vers le CRUD Employé
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', Utilisateur::class); // Lien vers le CRUD Utilisateur
    }
}
