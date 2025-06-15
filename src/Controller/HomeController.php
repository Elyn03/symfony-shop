<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $allProducts = $entityManager->getRepository(Product::class)->findAll();
        $isAdmin = $this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles(), true);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'allProducts' => $allProducts,
            'isAdmin' => $isAdmin,
        ]);
    }

    #[Route('/change/language', name: 'app_home_language')]
    public function changeLanguage(Request $request): Response
    {
        $currentLocale = $request->getLocale();
        $newLocale = $currentLocale === 'en' ? 'fr' : 'en';

        $request->getSession()->set('_locale', $newLocale);

        return $this->redirectToRoute('app_home', ['_locale' => $newLocale]);
    }

}
