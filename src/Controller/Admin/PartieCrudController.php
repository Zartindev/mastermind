<?php

namespace App\Controller\Admin;

use App\Entity\Partie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PartieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partie::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
