<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $allProducts = $entityManager->getRepository(Product::class)->findAll();
        $admins = $entityManager->getRepository(User::class)->findAllAdmins();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'allProducts' => $allProducts,
            'admins' => $admins,
        ]);
    }
}
