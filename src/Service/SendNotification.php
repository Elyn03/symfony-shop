<?php

namespace App\Service;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class SendNotification
{
    public function  __construct(private EntityManagerInterface $entityManager, private TranslatorInterface $translator)
    {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    public function sendNotification($user, $type, $item): void
    {
        $title = "";
        switch ($type) {
            case "PRODUCT_UPDATED":
                $title = $item . " " . $this->translator->trans('notification.updated');
                break;
            case "PRODUCT_BOUGHT":
                $title = $item . " " . $this->translator->trans('notification.bought');
                break;
            case "PRODUCT_DELETED":
                $title = $item . " " . $this->translator->trans('notification.deleted');
                break;
            case "PRODUCT_CREATED":
                $title = $this->translator->trans('notification.created') . " " . $item;
                break;
            default:
                $title = $this->translator->trans('notification.default');
                break;
        }

        $label = [
            "type" => $type,
            "title" => $title,
            "date" => new \DateTime(),
        ];

        $notice = new Notification();
        $notice->setUser($user);
        $notice->setCreatedAt(new \DateTime());
        $notice->setLabel($label);

        $this->entityManager->persist($notice);
        $this->entityManager->flush();
    }

}
