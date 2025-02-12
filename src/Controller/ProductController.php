<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Security\Voter\ProductVoter;
use App\Security\Voter\UserVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/product/create', name: 'app_product_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($product);
            $entityManager->flush();
        }

        return $this->render('product/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/product/{id}', name: 'app_product_view')]
    public function view(ProductRepository $productRepository, int $id): Response
    {
        $product = $productRepository->find($id);
        if (!$this->isGranted(ProductVoter::VIEW, $product)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour voir ce produit.');
            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/view.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/product/{id}/edit', name: 'app_product_edit')]
    public function edit(ProductRepository $productRepository, Request $request): Response
    {
        $product = $productRepository->find($request->get('id'));
        if (!$this->isGranted(ProductVoter::EDIT, $product)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour modifier ce produit.');
            return $this->redirectToRoute('app_product');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product
        ]);
    }

    #[Route('/product/{id}/delete', name: 'app_product_delete')]
    public function delete(ProductRepository $productRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = $productRepository->find($request->get('id'));
        if (!$this->isGranted(ProductVoter::DELETE, $product)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour supprimer ce produit.');
            return $this->redirectToRoute('app_product');
        }

        $entityManager->remove($product);
        $entityManager->flush();
        $this->addFlash('success', 'Utilisateur supprimée avec succès.');
        return $this->redirectToRoute('app_product');
    }
}
