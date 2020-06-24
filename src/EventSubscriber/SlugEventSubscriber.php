<?php


namespace App\EventSubscriber;


use App\Entity\Figure;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\AsciiSlugger;

class SlugEventSubscriber implements EventSubscriber
{
    /**
     * @var AsciiSlugger
     */
    private $slugger;

    public function __construct()
    {
        $this->slugger = new AsciiSlugger();
    }


    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate
        ];
    }

    public function prePersist(LifecycleEventArgs $event)
    {
        $this->buildSlug($event->getObject());

    }
    public function preUpdate(PreUpdateEventArgs $event)
    {
        $this->buildSlug($event->getObject());
    }

    private function buildSlug($entity)
    {
        if ($entity instanceof Figure) {
            $entity->setSlug($this->slugger->slug($entity->getName()));
        }
    }
}