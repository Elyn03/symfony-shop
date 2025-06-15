<?php

namespace App\Controller;

use App\Entity\User;
use App\Message\GivePointsMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user')]
    #[IsGranted("ROLE_ADMIN")]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $allUsers = $entityManager->getRepository(User::class)->findAll();

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'users' => $allUsers,
        ]);
    }

    #[Route('/user/toggle/{id}', name: 'app_user_toggle_active', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function toggleActive(string $id, EntityManagerInterface $entityManager): Response
    {
        $user = $entityManager->getRepository(User::class)->find($id);
        $user->setIsActive(!$user->isActive());

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_user');
    }

    #[Route('/users/give/points', name: 'app_user_give_points', methods: ['POST'])]
    #[IsGranted("ROLE_ADMIN")]
    public function givePoints(MessageBusInterface $messageBus): Response
    {
        $message = new GivePointsMessage(1000);
        $messageBus->dispatch($message);
        return $this->redirectToRoute('app_user');
    }
}
