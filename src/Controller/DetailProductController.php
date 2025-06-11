<?php

namespace App\Controller;

use App\Entity\Product;
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
}
