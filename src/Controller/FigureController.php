<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Figure;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\FigureRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @param Request $request
     * @param Figure $figure
     * @param EntityManagerInterface $entityManager
     * @param CommentRepository $commentRepository
     * @return Response
     */
    public function figure(Request $request, Figure $figure, EntityManagerInterface $entityManager, CommentRepository $commentRepository)
    {
        $comments = $commentRepository->findAllComments($figure->getId());
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($request->isMethod('POST') && $form->isSubmitted() && $form->isValid()) {
            $comment->setFigure($figure);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirect($this->generateUrl('post',
                    ['id' => $comment->getFigure()->getId(),
                    ]).'#comments');
        }

        return $this->render('figure.html.twig', [
            'figure' => $figure,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }
}
