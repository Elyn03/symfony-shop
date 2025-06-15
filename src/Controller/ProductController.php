<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductForm;
use App\Service\SendNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(Request $request, EntityManagerInterface $entityManager, SendNotification $sendNotification): Response
    {
        $product = new Product();
        $createForm = $this->createForm(ProductForm::class, $product);
        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
            $product->setUser($this->getUser());

            $entityManager->persist($product);
            $entityManager->flush();

            $sendNotification->sendNotification($this->getUser(), "PRODUCT_CREATED", $product->getName());
            return $this->redirectToRoute('app_product');
        }

        $allProducts = $entityManager->getRepository(Product::class)->findAll();

        // CREATE edit forms for each product
        $editForms = [];
        foreach ($allProducts as $product) {
            $form = $this->createForm(ProductForm::class, $product, [
                'action' => $this->generateUrl('app_product_action', ['id' => $product->getId()]),
                'method' => 'POST',
            ]);
            $editForms[$product->getId()] = $form->createView();
        }

        return $this->render('product/index.html.twig', [
            'create_product_form' => $createForm,
            'edit_product_form' => $editForms,
            'products' => $allProducts,
        ]);
    }

    #[Route('/product/action/{id}', name: 'app_product_action', methods: ['POST'])]
    public function action(Product $product, Request $request, EntityManagerInterface $entityManager, SendNotification $sendNotification): Response
    {
        $action = $request->request->get('action');

        if ($action === "delete") {
            $entityManager->remove($product);
            $entityManager->flush();

            $sendNotification->sendNotification($this->getUser(), "PRODUCT_DELETED", $product->getName());
            return $this->redirectToRoute('app_product');
        }

        $form = $this->createForm(ProductForm::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $sendNotification->sendNotification($this->getUser(), "PRODUCT_UPDATED", $product->getName());
        }

        return $this->redirectToRoute('app_product');
    }

}
