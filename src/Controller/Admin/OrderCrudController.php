<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Form\OrderDetailsType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            MoneyField::new('total_price')
                ->setCurrency('EUR'),
            BooleanField::new('isPaid')
                ->setLabel('Payé')
                ->setHelp('Cocher pour marquer la commande comme payée'),
            CollectionField::new('orderDetails', 'Produits achetés')
                ->setEntryType(OrderDetailsType::class)
                ->setFormTypeOption('by_reference', false)
                ->allowAdd()
                ->allowDelete()
                ->onlyOnForms(),
            CollectionField::new('orderDetails', 'Produits achetés')
                ->onlyOnDetail()
                ->formatValue(function ($value) {
                    if ($value instanceof \Doctrine\Common\Collections\Collection) {
                        $list = '<ul>';
                        foreach ($value as $orderDetail) {
                            $productName = $orderDetail->getProduct() ? $orderDetail->getProduct()->getName() : 'Produit inconnu';
                            $list .= '<li>' . htmlspecialchars($productName) . '</li>';
                        }
                        $list .= '</ul>';
                        return $list;
                    }
                    return '<p>Aucun produit</p>';
                }),
          
            AssociationField::new('user')
                ->setLabel('Utilisateur')
                ->setHelp('Utilisateur ayant passé la commande')
                ->setFormTypeOption('choice_label', function ($user) {
                    return $user->getFirstName() . ' ' . $user->getLastName();
                }),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add('index', 'detail');
    }
    
}
