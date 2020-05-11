<?php

namespace App\Controller\Logged;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
    /**
     * @Route("logged/link/edit", name="edit_link")
     * @param Request $request
     * @return Response
     */
    public function editLink(Request $request)
    {

        return $this->render('logged/link/edit.html.twig');
    }

    /**
     * @Route("logged/link/delete", name="delete_link")
     */
    public function deleteLink()
    {

    }

}
