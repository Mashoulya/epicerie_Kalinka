<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('first_name', 'Prénom')
                ->setLabel('Prénom')
                ->setHelp('Prénom de l\'utilisateur'),
            TextField::new('last_name', 'Nom')
                ->setLabel('Nom')
                ->setHelp('Nom de l\'utilisateur'),
            TextField::new('email', 'Email')
                ->setLabel('Email')
                ->setHelp('Email de l\'utilisateur'),
                TextField::new('tel', 'Téléphone')
                ->setLabel('Téléphone')
                ->setHelp('Téléphone de l\'utilisateur'),
            TextField::new('roles', 'Rôles')
                ->setLabel('Rôles')
                ->setHelp('Rôles de l\'utilisateur')
                ->hideOnIndex(),
           
        ];
    }

}
