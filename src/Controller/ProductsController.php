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
use Symfony\Component\Security\Http\Attribute\IsGranted;


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
    #[Route('/products/publique', 'products.index.public', methods: ['GET'])]
    public function indexPublic(
        ProductsRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $products = $paginator->paginate(
            $repository->findPublicProducts(null),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/products/index_public.html.twig', [
            'products' => $products
        ]);
    }
    /************************************************************************* */

    /**
     * This controller allow us to create news products
     *
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */

    #[IsGranted('ROLE_ADMIN')]
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
    /*****************************************************************************/

    /**
     * This controller allow us to edit our products .
     *
     * @param ProductsRepository $repository
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param [type] $id
     * @return Response
     */

    #[IsGranted('ROLE_ADMIN')]
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


    /*************************************************************************** */
    /**
     * This Controller allow us to delete Products .
     *
     * @param EntityManagerInterface $manager
     * @param ProductsRepository $repository
     * @param Products $products
     * @param [type] $id
     * @return Response
     */

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/products/suppression/{id}', 'products.delete', methods: ['GET'])]
    public function delete(
        EntityManagerInterface $manager,
        ProductsRepository $repository,
        Products $products,
        $id
    ): Response {
        $products = $repository->findOneBy(["id" => $id]);
        if (!$products) {
            $this->addflash(
                'warning',
                'Le produit en question n\'a pas été trouvé !'
            );

            return $this->redirectToRoute('products');
        }
        $manager->remove($products);
        $manager->flush();

        $this->addflash(
            'success',
            'Le produits a été supprimé avec succès !'
        );

        return $this->redirectToRoute('products');
    }

    /************************************************************************* */
    #[Security("is_granted('ROLE_USER') and products.getIsPublic === true")]
    #[Route('/products/show/{id}', 'products.show', methods: ['GET'])]
    public function show(
        ProductsRepository $repository,
        $id
    ): Response {
        $products = $repository->findOneBy(["id" => $id]);


        if (!$products) {
            // Le produit n'existe pas, renvoyez une réponse d'erreur
            $this->addflash(
                'warning',
                'Le produit en question n\'a pas été trouvé !'
            );
            return $this->redirectToRoute('home.index');
        }

        return $this->render('pages/products/show.html.twig', [
            'products' => $products,
        ]);
    }
}
