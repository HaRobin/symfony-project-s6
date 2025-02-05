<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Security\Voter\UserVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $productRepository): Response
    {
        if (!$this->isGranted(UserVoter::VIEW)) {
            $this->addFlash('error', 'Vous n\'avez pas les droits nécessaires pour lister les produits.');
            return $this->redirectToRoute('home');
        }
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }
}
