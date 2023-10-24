<?php

namespace App\Controller;

use App\Repository\ArrivagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArrivagesController extends AbstractController
{
    /**
     * This controller allow us to display all the arrival
     *
     * @param ArrivagesRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/arrivages', name: 'arrivages.index', methods: ['GET'])]
    public function index(
        ArrivagesRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $arrivages = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/arrivages/index.html.twig', [
            'arrivages' => $arrivages,
        ]);
    }
}
