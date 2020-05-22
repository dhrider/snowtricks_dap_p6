<?php


namespace App\Form\EventListener;


use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

class UserPhotoEventListener implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{
    private $request;
    private $imageDirectory;

    public function __construct(RequestStack $requestStack, string $imageDirectory)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->imageDirectory = $imageDirectory;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit'
        ];
    }

    public function postSubmit(FormEvent $formEvent)
    {

            // TODO save photo in directory & add image to user

    }
}