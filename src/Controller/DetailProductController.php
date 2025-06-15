<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\Product;
use App\Service\SendNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DetailProductController extends AbstractController
{
    #[Route('/detail/product/{id}', name: 'app_detail_product')]
    public function index(string $id, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        return $this->render('detail_product/index.html.twig', [
            'controller_name' => 'DetailProductController',
            'product' => $product,
        ]);
    }

    #[Route('/buy/product/{id}', name: 'app_buy_product', methods: ['POST'])]
    public function buyProduct(string $id, EntityManagerInterface $entityManager, SendNotification $sendNotification): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);
        $user = $this->getUser();

        $newPoints = $user->getPoints() - $product->getPrice();
        $user->setPoints($newPoints);

        $entityManager->persist($product);
        $entityManager->flush();

        $sendNotification->sendNotification($user, "PRODUCT_BOUGHT", $product->getName());
        return $this->redirectToRoute('app_detail_product', ['id' => $id]);
    }
}
