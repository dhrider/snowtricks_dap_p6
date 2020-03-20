<?php

namespace App\Controller;

use App\Repository\FigureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureController extends AbstractController
{
    public function listTricks(FigureRepository $figureRepository)
    {
        return $figureRepository->findAll();
    }
}
