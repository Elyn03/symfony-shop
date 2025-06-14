<?php

namespace App\Service;

use App\Entity\Notification;
use Doctrine\ORM\EntityManagerInterface;

class SendNotification
{
    public function sendNotification($user, $type, $productName, EntityManagerInterface $entityManager): void
    {
        $title = "";
        switch ($type) {
            case "PRODUCT_UPDATED":
                $title = $productName . " a été modifié!";
                break;
            case "PRODUCT_BOUGHT":
                $title = $productName . " a été acheté!";
                break;
            case "PRODUCT_DELETED":
                $title = $productName . " a été supprimé!";
                break;
            default:
                $title = "not found";
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

        $entityManager->persist($notice);
        $entityManager->flush();
    }

}
