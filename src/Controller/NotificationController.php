<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class NotificationController extends AbstractController
{
    #[Route('/notification', name: 'app_notification')]
//    #[IsGranted("ROLE_ADMIN")]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $notifications = $entityManager->getRepository(Notification::class)->findBy([], ['createdAt' => 'DESC']);


        return $this->render('notification/index.html.twig', [
            'controller_name' => 'NotificationController',
            'notifications' => $notifications
        ]);
    }
}
