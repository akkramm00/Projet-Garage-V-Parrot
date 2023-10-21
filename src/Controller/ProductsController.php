<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    /**
     * This controller dispaly all products
     *
     * @param ProductsRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/products', name: 'products', methods: ['GET'])]
    public function index(
        ProductsRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $products = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/products/index.html.twig', [
            'products' => $products
        ]);
    }
    /************************************************************************* */

    /**
     * This controller allow us to create news produts
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[Route('/products/nouveau', name: 'products.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $products = new Products();
        $form = $this->createForm(ProductsType::class, $products);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $form->getData();

            $manager->persist($products);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été créé avec succès !'
            );

            return $this->redirectToRoute('products');
        }

        return $this->render('pages/products/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /*************************************************************************** */

    #[Route('/products/edition/{id}', 'products.edit', methods: ['GET', 'POST'])]
    public function edit(
        ProductsRepository $repository,
        Request $request,
        EntityManagerInterface $manager,
        $id
    ): Response {
        $products = $repository->findOneBy(["id" => $id]);
        $form = $this->createForm(ProductsType::class, $products);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $products = $form->getData();

            $manager->persist($products);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été modifié avec succès !'
            );

            return $this->redirectToRoute('products');
        }

        return $this->render('pages/products/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
