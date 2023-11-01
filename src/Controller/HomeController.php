<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', 'home.index', methods: ['GET'])]
    public function index(
        ProductsRepository $productsRepository
    ): Response {
        return $this->render('pages/home.html.twig', [
            'products' => $productsRepository->findPublicProducts(3)
        ]);
    }
}
