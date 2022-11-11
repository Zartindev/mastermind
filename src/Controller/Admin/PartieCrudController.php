<?php

namespace App\Controller\Admin;

use App\Entity\Partie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class PartieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partie::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            IntegerField::new('nbcoups'),
            IntegerField::new('temps'),
            BooleanField::new('resultat'),
            DateField::new('date'),
        ];
    }
    
}
