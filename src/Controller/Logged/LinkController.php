<?php

namespace App\Controller\Logged;

use App\Entity\Link;
use App\Form\LinkType;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
    /**
     * @Route("logged/link/{id}", name="edit_link")
     * @param Link $link
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function editLink(Link $link, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        $success = false;

        if ($form->isSubmitted() && $form->isValid()) {
            $link->setUrl($request->request->all()['link']['link']);
            $entityManager->persist($link);
            $entityManager->flush();

            $success = true;
            $session = $this->container->get('session');
            $session->getFlashBag()->set('success', 'Your image has been successfully updated !');

            return $this->redirect($this->generateUrl('edit_figure', [
                'id' => $link->getFigure()->getId(),
                'success' => $success
            ]));
        }

        return $this->render('logged/link/edit.html.twig', [
            'form' => $form->createView(),
            'success' => $success
        ]);
    }

    /**
     * @Route("logged/link/delete/{id}", name="delete_link")
     * @param Link $link
     * @param EntityManagerInterface $entityManager
     * @param LinkRepository $linkRepository
     */
    public function deleteLink(Link $link, EntityManagerInterface $entityManager, LinkRepository $linkRepository)
    {
        $entityManager->remove($linkRepository->find($link->getId()));
        $entityManager->flush();

        return $this->redirect($this->generateUrl('edit_figure', ['id' => $link->getFigure()->getId()]));
    }

}
