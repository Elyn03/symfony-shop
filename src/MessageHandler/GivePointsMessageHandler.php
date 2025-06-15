<?php

namespace App\MessageHandler;

use App\Entity\User;
use App\Message\GivePointsMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GivePointsMessageHandler{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(GivePointsMessage $message): void
    {
        $activeUsers = $this->entityManager->getRepository(User::class)->findBy(['isActive' => true]);

        foreach ($activeUsers as $user) {
            $user->setPoints($user->getPoints() + $message->getPoints());
            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();
    }
}
