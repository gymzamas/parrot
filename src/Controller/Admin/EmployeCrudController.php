<?php

/// src/Controller/Admin/EmployeCrudController.php

namespace App\Controller\Admin;

use App\Entity\Employe;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class EmployeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Employe::class;
    }

    // Tu peux personnaliser les champs du formulaire ici si nécessaire
}

