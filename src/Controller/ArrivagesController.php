<?php

namespace App\Controller;

use App\Entity\Arrivages;
use App\Form\ArrivagesType;
use App\Repository\ArrivagesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
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

    /*************************************************************************** */
    /**
     * This Controller allow us to create a new Arrival !
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/arrivages/nouveau', name: 'arrivages.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $arrivages = new Arrivages();
        $form = $this->createForm(ArrivagesType::class, $arrivages);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $arrivages = $form->getData();

            $manager->persist($arrivages);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre Arrivage a été créé avec succès !'
            );

            return $this->redirectToRoute('arrivages.index');
        }


        return $this->render('pages/arrivages/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
