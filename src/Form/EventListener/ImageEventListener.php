<?php


namespace App\Form\EventListener;


use App\Entity\Figure;
use App\Entity\Image;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

class ImageEventListener implements EventSubscriberInterface
{
    private $request;
    private $imageDirectory;

    public function __construct(RequestStack $requestStack, string $imageDirectory)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->imageDirectory = $imageDirectory;
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
            $links = $this->request->request->all()['post']['videoLinks'];
        }

        if(isset($files['image'])) {
            $images = $files['image'];
        }

        foreach($images as $file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate(
                'Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()',
                $originalFilename
            );
            $newFilename = $safeFilename . '-' . uniqid('', true) . '.' . $file->guessExtension();

            $file->move($this->imageDirectory, $newFilename);

            if ($formEvent->getData() instanceof Figure) {
                $image = new Image();
                $formEvent->getData()->addImage($image);
                $image->setName($newFilename);
                $image->setType($file->getClientMimeType());
            } else {
                unlink($this->imageDirectory . $formEvent->getData()->getName());
                $image = $formEvent->getData();
                $image->setName($newFilename);
                $image->setType($file->getClientMimeType());

                $formEvent->setData($image);
            }
        }

        foreach ($links as $link) {
            $formEvent->getData()->addVideoLink($link);
        }
    }
}