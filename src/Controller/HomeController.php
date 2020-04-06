<?php

namespace App\Controller;

use App\Entity\Figure;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param FigureRepository $figureRepository
     * @return Response
     */
    public function home(FigureRepository $figureRepository)
    {
        $trickList = $figureRepository->findAll();

        return $this->render('home.html.twig', [
            'tricks' => $trickList
        ]);
    }
}
