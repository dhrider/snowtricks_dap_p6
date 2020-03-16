<?php

namespace App\Controller;

use App\Entity\Figure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function home(EntityManagerInterface $entityManager)
    {
        $trickList = $entityManager->getRepository(Figure::class)->findAll();

        return $this->render('home.html.twig', [
            'tricks' => $trickList
        ]);
    }
}
