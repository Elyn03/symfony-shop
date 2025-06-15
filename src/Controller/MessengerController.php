<?php

namespace App\Controller;

use App\Message\GivePointsMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class MessengerController extends AbstractController
{
    #[Route('/messenger/give/points', name: 'app_messenger_give_points', methods: ['POST'])]
    public function index(MessageBusInterface $messageBus): Response
    {
        $message = new GivePointsMessage(1000);
        $messageBus->dispatch($message);
        return $this->redirectToRoute('app_user');
    }
}
