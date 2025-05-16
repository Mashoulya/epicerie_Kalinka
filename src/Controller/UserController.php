<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(UserRepository $userRepo): Response
    {

        $users = $userRepo->findAll();
        if (!$users) {
            throw $this->createNotFoundException('Aucun utilisateur trouvé');
        }
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $users,
        ]);
    }

    #[Route('/user/{id}', name: 'app_user_show')]

    public function show(int $id, UserRepository $userRepo): Response
    {

        $user = $userRepo->findOneBy(['id' => $id]);
        if (!$user) {
            throw $this->createNotFoundException('L\'utilisateur n\'existe pas');
        }
        return $this->render('user/showUser.html.twig', [
            'controller_name' => 'UserController',
            'user' => $user,
            'id' => $id,
        ]);
    }
}
