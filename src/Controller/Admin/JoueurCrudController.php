<?php

namespace App\Controller\Admin;

use App\Entity\Joueur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

class JoueurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Joueur::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('username')->setFormTypeOption('disabled','disabled'),
            ArrayField::new('roles')->setPermission('ROLE_SUPERADMIN'),
            TextField::new('email')->setFormTypeOption('disabled','disabled'),
            TextField::new('imgProfil'),
            TextField::new('imgBanniere'),
        ];
    }
    
}
