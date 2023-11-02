<?php

namespace App\Controller;

use App\Repository\ReviewRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
    #[Route('/review', name: 'review', methods: ['GET'])]
    /**
     * This controller allow us to display all the reviews
     *
     * @param ReviewRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(
        ReviewRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $review = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/review/index.html.twig', [
            'review' => $review
        ]);
    }
}
