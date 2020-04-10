<?php

namespace App\Controller\Logged;

use App\Entity\Figure;
use App\Form\FigureType;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $em->persist($figure);
            $em->flush();
            return $this->redirectToRoute('create_figure');
        }

        return $this->render('logged/figureCreation.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/logged/edit/{id}", name="edit_figure")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Figure $figure
     * @return Response
     * @throws Exception
     */
    public function editFigure(Request $request, EntityManagerInterface $em, Figure $figure) {
        $form = $this->createForm(FigureType::class, $figure);
        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $figure->setDateLastModification(new \DateTime());
            $em->persist($figure);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('logged/figureEdit.html.twig', [
            'form' => $form->createView(),
            'figure' => $figure
        ]);
    }

    /**
     * @Route("/logged/delete/{id})", name="delete_figure")
     * @param EntityManagerInterface $em
     * @param Figure $figure
     * @return RedirectResponse
     */
    public function deleteFigure(EntityManagerInterface  $em, Figure $figure) {
        // on récupère les images liées à la figure
        $images = $figure->getImages();
        //on les efface du dossier upload
        foreach ($images as $image) {
            unlink($image->getImagePath());
        }
        // on supprime la figure de la BDD
        $em->remove($figure);
        $em->flush();
        //on redirige vers la page 'home'
        return $this->redirectToRoute('home');
    }
}


