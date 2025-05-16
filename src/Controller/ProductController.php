<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepo): Response
    {
        $products = $productRepo->findAll();
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products,
        ]);
    }

    #[Route('/product/{slug}', name: 'app_product_show')]

    public function show($slug, ProductRepository $productRepo): Response
    {

        $product = $productRepo->findOneBy(['slug' => $slug]);
        if (!$product) {
            throw $this->createNotFoundException('Le produit n\'existe pas');
        }
        return $this->render('product/show.html.twig', [
            'controller_name' => 'ProductController',
            'product' => $product,
            'slug' => $slug,
        ]);
    }
}
