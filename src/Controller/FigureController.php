<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Repository\FigureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FigureController extends AbstractController
{
    public function listTricks(FigureRepository $figureRepository)
    {
        return $figureRepository->findAll();
    }

    /**
     * @Route(path="figure/{id}", name="figure")
     * @param Figure $figure
     * @return Response
     */
    public function figure(Figure $figure)
    {
        return $this->render('figure.html.twig', [
            'figure' => $figure
        ]);
    }
}
