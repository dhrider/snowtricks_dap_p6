<?php

namespace App\Controller\Logged;

use App\Entity\Figure;
use App\Entity\Media;
use App\Form\FigureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class FigureController extends AbstractController
{
    /**
     * @Route("/logged/create", name="create_figure")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function createFigure(Request $request, EntityManagerInterface $em)
    {
        $figure = new Figure();

        $form = $this->createForm(FigureType::class, $figure);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $uploadedFile = $form->get('file')->getData();
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate(
                'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                $originalFilename
                );
            $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();

            try {
                $uploadedFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );
            } catch (FileException $e) {

            }
            $media = new Media();
            $media->setName($newFilename);
            $media->setType('image/jpeg');
            $media->setFigure($figure);

            $em->persist($media);
            $em->persist($figure);
            $em->flush();

            $this->redirectToRoute('create_figure');
        }


        return $this->render('logged/figureCreation.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
