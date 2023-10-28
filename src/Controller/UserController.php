<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user.index', methods: ['GET'])]
    /**
     * This controller display all users
     *
     * @param UserRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function index(
        UserRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $user = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/user/index.html.twig', [
            'user' => $user
        ]);
    }
    /*********************************************************************** */
    /**
     * This controller allow us to edit user's profile
     *
     * @param UserRepository $repository
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param [type] $id
     * @return Response
     */
    #[Route('/utilisateur/edition/{id}', name: 'user.edit', methods: ['GET', 'POST'])]
    public function edit(
        UserRepository $repository,
        Request $request,
        EntityManagerInterface $manager,
        UserPasswordHasherInterface $hasher,
        $id
    ): Response {

        $user = $repository->findOneBy(["id" => $id]);

        // if (!$this->getUser()) {
        //     return $this->redirectToRoute('security.login');
        // }

        // if ($this->getUser() !== $user) {
        //     return $this->redirectToRoute('products');
        // }


        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()->getPlainPassword()));
            $user = $form->getData();
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Les informations de votre compte ont bien été modifiées !'
            );

            return $this->redirectToRoute('products');
        } else {
            $this->addFlash(
                'warning',
                'Le mot de passe renseigné est incorrect .'
            );
        }

        return $this->render('pages/user/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
