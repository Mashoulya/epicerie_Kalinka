<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            TextField::new('image')
                ->setLabel('Image URL')
                ->setHelp('URL de l\'image du produit'),
            TextField::new('price')
                ->setLabel('Prix')
                ->setHelp('Prix du produit'),
            IntegerField::new('stock')
                ->setLabel('Stock')
                ->setHelp('Quantité en stock'),
            BooleanField::new('active')
                ->setLabel('Actif')
                ->setHelp('Cocher pour activer ou désactiver le produit'),
            TextField::new('category.name', 'Catégorie')
                ->setLabel('Catégorie')
                ->setHelp('Catégorie du produit')
                ->hideOnIndex(),
        
        ];
    }
}
