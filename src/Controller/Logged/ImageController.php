<?php

namespace App\Controller\Logged;


use App\Entity\Image;
use App\Form\ImageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImageController extends AbstractController
{
    /**
     * @Route(path="/logged/image/{id}", name="edit_image")
     * @param Image $image
     * @param Request $request
     * @return Response
     */
    public function editImage(Image $image, Request $request)
    {
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($image);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('logged/image/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
