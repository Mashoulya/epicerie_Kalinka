<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits');
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
            AssociationField::new('category')
                ->setLabel('Catégorie')
                ->setHelp('Sélectionner la catégorie du produit'),
        
        ];
    }
}
