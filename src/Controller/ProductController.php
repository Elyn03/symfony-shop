<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setCreatedAt(new \DateTime());
            $product->setUser($this->getUser());

            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('app_product');
        }

        $myProducts = $entityManager->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'product_form' => $form,
            'products' => $myProducts,
        ]);
    }
}
