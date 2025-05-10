<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\OrderDetails;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator
        ->setController(UserCrudController::class)
        ->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Epicerie Kalinka');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home'),
            // MenuItem::section('E-commerce'),
            MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class),
            // ->setPermission('ROLE_ADMIN');
            MenuItem::linkToCrud('Catégories de produits', 'fas fa-tags', Category::class),
            // ->setPermission('ROLE_ADMIN');
            MenuItem::linkToCrud('Produits', 'fas fa-box', Product::class),
            // ->setPermission('ROLE_ADMIN');
            MenuItem::linkToCrud('Commandes', 'fas fa-shopping-cart', Order::class),
            // ->setPermission('ROLE_ADMIN');
           ];
    }
}
