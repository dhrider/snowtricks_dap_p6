<?php


namespace App\Form\EventListener;

use App\Entity\Link;
use App\Entity\Figure;
use App\Entity\Image;
use App\File\FileUploader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

class ImageEventListener implements EventSubscriberInterface
{
    private $request;
    private $filesTargetDirectory;
    private $fileUploader;

    public function __construct(RequestStack $requestStack, string $filesTargetDirectory, FileUploader $fileUploader)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->filesTargetDirectory = $filesTargetDirectory;
        $this->fileUploader = $fileUploader;
    }
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit'
        ];
    }

    public function postSubmit(FormEvent $formEvent)
    {
        $files = $this->request->files->all();
        $links = [];
        $images = [];

        if (isset($files['post'])) {
            $images = $files['post']['images'];
            if(isset($this->request->request->all()['post']['links']))
                $links = $this->request->request->all()['post']['links'];
        }

        if(isset($files['image'])) {
            $images = $files['image'];
        }

        foreach($images as $file) {
            $newFilename = $this->fileUploader->upload($file, 'images');

            if ($formEvent->getData() instanceof Figure) {
                $image = new Image();
                $formEvent->getData()->addImage($image);
                $image->setName($newFilename);
                $image->setType($file->getClientMimeType());
            } else {
                unlink($this->filesTargetDirectory.'images/'.$formEvent->getData()->getName());
                $image = $formEvent->getData();
                $image->setName($newFilename);
                $image->setType($file->getClientMimeType());

                $formEvent->setData($image);
            }
        }

        foreach ($links as $link) {
            $newLink = new Link();
            $formEvent->getData()->addLink($newLink);
            $newLink->setUrl($link);
        }
    }
}