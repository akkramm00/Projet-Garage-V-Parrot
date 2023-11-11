<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ImagesController extends AbstractController
{
    #[Route('/images', name: 'images.index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]

    public function index(
        ImagesRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $images = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/images/index.html.twig', [
            'images' => $images,
        ]);
    }

    #[Route('/images/nouveau', name: 'images.new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $images = new Images();
        $form = $this->createForm(ImagesType::class, $images);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle image file uploads
            $uploadedImages = $form->get('images')->getData();

            foreach ($uploadedImages as $uploadedImage) {
                $image = new Image(); // Create a new Image entity for each uploaded image
                $image->setImages($images); // Associate the image with the parent Images entity

                // Handle each uploaded image (e.g., using VichUploader)
                // 1. Generate a unique file name
                $fileName = md5(uniqid()) . '.' . $uploadedImage->guessExtension();

                // 2. Set the image file name (this is the field expected by VichUploader)
                $image->setImageFile($fileName);

                // 3. Move the uploaded file to the desired directory using VichUploader
                $image->setImageFile($uploadedImage); // Set the image file directly

                // Persist the Image entity
                $manager->persist($image);
            }

            $manager->persist($images);
            $manager->flush();

            $this->addFlash(
                'success',
                'Vos images ont été téléchargées avec succès!'
            );

            return $this->redirectToRoute('images.index');
        }

        return $this->render('pages/images/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
