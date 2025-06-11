<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $allUsers = $entityManager->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $allUsers,
        ]);
    }

    #[Route('/user/toggle/{id}', name: 'app_user_toggle_active', methods: ['POST'])]
    public function toggleActive(string $id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        $user->setIsActive(!$user->isActive());

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user');
    }

    #[Route('/user/give/points', name: 'app_user_give_points', methods: ['POST'])]
    public function givePoints(EntityManagerInterface $entityManager): Response
    {
        $activeUsers = $entityManager->getRepository(User::class)->findBy(['isActive' => true]);

        foreach ($activeUsers as $user) {
            $user->setPoints($user->getPoints() + 1000);
        }

        $entityManager->flush();
        $this->addFlash('success', 'Tous les utilisateurs actifs ont reçu +1000 points.');

        return $this->redirectToRoute('app_user');
    }
}
