<?php

namespace App\Controller\Logged;

use App\Entity\Figure;
use App\Entity\Image;
use App\Form\FigureType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FigureController extends AbstractController
{
    private $filesTargetDirectory;
    private $entityManager;

    public function __construct(string $filesTargetDirectory, EntityManagerInterface $entityManager)
    {
        $this->filesTargetDirectory = $filesTargetDirectory;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/logged/create", name="create_figure")
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return Response
     */
    public function createFigure(Request $request, ValidatorInterface $validator)
    {
        $figure = new Figure();

        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        $success = false;

        if($request->isMethod('POST') && $form->isSubmitted()) {
            if($form->isValid()) {
                $success = true;
                $session = $this->container->get('session');
                $session->getFlashBag()->set('success', 'Your Trick has been successfully created !');

                $this->entityManager->persist($figure);
                $this->entityManager->flush();

                return $this->redirectToRoute('create_figure', [
                    'success' => $success
                ]);
            } else {
                foreach ($figure->getImages() as $image) {
                    unlink($this->filesTargetDirectory.'images/'. $image->getName());
                    $this->entityManager->remove($image);
                }
                $this->entityManager->flush();
            }
        }

        return $this->render('logged/figureCreation.html.twig', array(
            'form' => $form->createView(),
            'success' => $success
        ));
    }

    /**
     * @Route("/logged/edit/{slug}", name="edit_figure")
     * @param Request $request
     * @param Figure $figure
     * @return Response
     * @throws Exception
     */
    public function editFigure(Request $request, Figure $figure) {
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $figure->setUpdatedAt(new \DateTime());
            $this->entityManager->persist($figure);
            $this->entityManager->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('logged/figureEdit.html.twig', [
            'form' => $form->createView(),
            'figure' => $figure
        ]);
    }

    /**
     * @Route("/logged/delete/{slug})", name="delete_figure")
     * @param Figure $figure
     * @return RedirectResponse
     */
    public function deleteFigure(Figure $figure) {
        // on récupère les images liées à la figure
        $images = $figure->getImages();
        //on les efface du dossier upload
        foreach ($images as $image) {
            unlink($this->filesTargetDirectory.'images/'.$image->getName());
        }
        // on supprime la figure de la BDD
        $this->entityManager->remove($figure);
        $this->entityManager->flush();
        //on redirige vers la page 'home'
        return $this->redirectToRoute('home');
    }
}


