<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class OrderController extends AbstractController
{
    #[Route('/my-orders', name: 'app_user_orders')]
    
    public function listOrders(OrderRepository $orderRepository): Response
    {
        // commandes de l'utilisateur connecté
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('app_login');
        }
        $newOrders = $orderRepository->findNonPaidOrders([
            'user' => $user,
            'paid' => false
        ]);
        $paidOrders = $orderRepository->findPaidOrders([
            'user' => $user,
            'paid' => true
        ]);
    
        return $this->render('order/index.html.twig', [
            'paidOrders' => $paidOrders,
            'newOrders' => $newOrders,

        ]);
    }

    #[Route('/create-order', name: 'app_create_order')]

    public function createOrder(SessionInterface $session,ProductRepository $productRepository, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
  
        $cart = $session->get('cart', []);
        if($cart === []){
            return $this->redirectToRoute('app_index');
        }
        $orders = new Order();
        $orders->setUser($this->getUser());
        // $orders->setReference(uniqid());      MODIFIER!!!
        $orders->setCreatedAt(new \DateTimeImmutable());
    
        $totalPrice = 0.0;
    
        // on parcourt le panier pour créer les détails de la commande
        foreach ($cart as $item=> $quantity) {
            $product = $productRepository->find($item);
            if (!$product || $product->getStock() === 0) {
                unset($cart[$item]);
                $name = $product ? $product->getName() : 'inconnu';
                $this->addFlash('error', "Le produit {$name} est en rupture");
                continue;
            }
            if ($product->getStock() < $quantity) {
                $this->addFlash('error', "La quantité demandée pour le produit {$product->getName()} est supérieure à la quantité en stock");
                continue;
            }

            $orderDetails = new OrderDetails();
            $orderDetails->setProduct($product);
            $orderDetails->setQuantity($quantity);
            $orderDetails->setUserOrder($orders);
    
            // on ajoute le détail de la commande à la commande
            $orders->addOrderDetail($orderDetails);
    
            // on calcule le prix total
            $totalPrice += $product->getPrice() * $quantity;

            // mise à jour du stock
            $newStock = $product->getStock() - $quantity;
            $product->setStock($newStock);
        }

        $session->set('cart', $cart);

        if (count($orders->getOrderDetails()) === 0) {
            $this->addFlash('error', 'Aucun produit dans le panier');
            return $this->redirectToRoute('app_index'); // à définir la route
        }

        $orders->setIsPaid(false);
        $orders->setTotalPrice($totalPrice);

        $em->persist($orders);
        $em->flush();

        // on vide lepanier
        $session->remove('cart');

        // message de succès
        $this->addFlash('success', 'Votre commande a été créée avec succès !');

        return $this->render('order/createOrder.html.twig', [
            'orders' => $orders,
            'totalPrice' => $totalPrice,
        ]);
    }
}