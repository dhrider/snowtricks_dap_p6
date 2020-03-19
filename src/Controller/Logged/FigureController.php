<?php

namespace App\Controller\Logged;

use App\Entity\Figure;
use App\Form\FigureType;
use Doctrine\ORM\EntityManagerInterface;
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

            $em->persist($figure);
            $em->flush();

            return $this->redirectToRoute('create_figure');

        }

        return $this->render('logged/figureCreation.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/logged/edit", name="edit_figure")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function editFigure(Request $request, EntityManagerInterface $em) {



        return $this->render('logged.figureEdit.html.twig', [

        ]);
    }
}
