<?php


namespace App\Controller;


use App\Entity\Figure;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comments/{figure}", name="comment_index")
     * @param $figure
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @return Response
     */
    public function commentList($figure, CommentRepository $commentRepository, Request $request)
    {
        /*$comments = $commentRepository->findAllComments($figure);


        return $this->render('Comment/comment.html.twig', [
            'comments' => $comments
        ]);*/

        $page = $request->query->get('page', 1);

        $nbCommentPerPage = 10;
        $comments = $commentRepository->findAllCommentsPaginate($figure, $page, $nbCommentPerPage);

        return $this->render('Comment/comment.html.twig', [
            'comments' => $comments,
            'pagination' => [
                'page' => $page,
                'nbPages' => ceil(count($comments) / $nbCommentPerPage),
                'nomRoute' => 'comment_index',
                'paramsRoute' => []
            ]
        ]);
    }
}