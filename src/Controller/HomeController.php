<?php

namespace App\Controller;

use App\Repository\ArrivagesRepository;
use App\Repository\ProductsRepository;
use App\Repository\ReviewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HomeController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY', message: 'Accès interdit', statusCode: 403, redirectTo: 'security.login')]
    #[Route('/', 'home.index', methods: ['GET'])]
    public function index(
        ProductsRepository $productsRepository,
        ArrivagesRepository $arrivagesRepository,
        ReviewRepository $reviewRepository,
    ): Response {
        return $this->render('pages/home.html.twig', [
            'products' => $productsRepository->findPublicProducts(3),
            'arrivages' => $arrivagesRepository->findPublicArrivages(3),
            'review' => $reviewRepository->findPublicReview(3)

        ]);
    }
}
