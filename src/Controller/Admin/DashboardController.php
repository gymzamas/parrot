<?php
namespace App\Controller\Admin;
namespace App\Controller\Admin;

use App\Entity\Employe;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Génère une URL pour le CRUD Employé dans le dashboard
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        $url = $adminUrlGenerator->setController(EmployeCrudController::class)->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Garage Parrot - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Employés', 'fas fa-user', Employe::class); // Lien vers le CRUD Employé
    }
}
