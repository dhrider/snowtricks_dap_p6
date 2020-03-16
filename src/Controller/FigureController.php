<?php

namespace App\Controller;

use App\Form\FigureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FigureController extends AbstractController
{
    public function listTricks(EntityManagerInterface $entityManager)
    {
        return $entityManager->getRepository(Figure::class)->findAll();
    }
}
