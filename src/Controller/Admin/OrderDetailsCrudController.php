<?php

namespace App\Controller\Admin;

use App\Entity\OrderDetails;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderDetailsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return OrderDetails::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('product.name', 'Nom du produit')
                ->setLabel('Nom du produit')
                ->setHelp('Nom du produit'),
            TextField::new('product.image', 'Image du produit')
                ->setLabel('Image du produit')
                ->setHelp('URL de l\'image du produit'),
            TextField::new('product.price', 'Prix du produit')
                ->setLabel('Prix du produit')
                ->setHelp('Prix du produit'),
            TextField::new('quantity', 'Quantité')
                ->setLabel('Quantité')
                ->setHelp('Quantité de produit commandée'),
            AssociationField::new('order', 'Commande')
                ->setLabel('Commande')
                ->setHelp('Commande associée à ce produit'),
            BooleanField::new('is_paid', 'Payé')
                ->setLabel('Payé')
                ->setHelp('Cocher pour marquer la commande comme payée'),
        ];
    }

}
