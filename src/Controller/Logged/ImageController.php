<?php

namespace App\Controller\Logged;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    private $imageDirectory;

    public function __construct(string $imageDirectory)
    {
        $this->imageDirectory = $imageDirectory;
    }

    /**
     * @Route(path="/logged/image/{id}", name="edit_image")
     * @param Image $image
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function editImage(Image $image, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        $success = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($image);
            $entityManager->flush();

            $success = true;
            $session = $this->container->get('session');
            $session->getFlashBag()->set('success', 'Your image has been successfully updated !');

            return $this->redirect($this->generateUrl('edit_figure', [
                'id' => $image->getFigure()->getId(),
                'success' => $success
            ]));
        }

        return $this->render('logged/image/edit.html.twig', [
            'form' => $form->createView(),
            'success' => $success
        ]);
    }

    /**
     * @Route(path="/logged/image/delete/{id}", name="delete_image")
     * @param Image $image
     * @param EntityManagerInterface $entityManager
     * @param ImageRepository $imageRepository
     * @return RedirectResponse
     */
    public function deleteImage(Image $image, EntityManagerInterface $entityManager, ImageRepository $imageRepository)
    {
        unlink($this->imageDirectory . $image->getName());
        $entityManager->remove($imageRepository->find($image->getId()));
        $entityManager->flush();

        return $this->redirect($this->generateUrl('edit_figure', ['id' => $image->getFigure()->getId()]));
    }
}
