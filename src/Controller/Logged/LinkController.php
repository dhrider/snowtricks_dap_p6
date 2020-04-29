<?php

namespace App\Controller\Logged;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
    /**
     * @Route("logged/link/edit", name="edit_link")
     * @param Request $request
     */
    public function editLink(Request $request)
    {

    }

    /**
     * @Route("logged/link/delete", name="delete_link")
     */
    public function deleteLink()
    {

    }

}
