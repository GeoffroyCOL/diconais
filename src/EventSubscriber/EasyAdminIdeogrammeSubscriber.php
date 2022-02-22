<?php

namespace App\EventSubscriber;

use App\Uploader\Attribute\UploaderAttributeReader;
use App\Uploader\Handler\UploaderHandler;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminIdeogrammeSubscriber implements EventSubscriberInterface
{
    public function __construct(private UploaderAttributeReader $reader, private UploaderHandler $handler)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['ideogrammePersist'],
            BeforeEntityUpdatedEvent::class => ['ideogrammeUpdate'],
            BeforeEntityDeletedEvent::class => ['ideogrammeDelete'],
        ];
    }

    public function ideogrammePersist(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        $media = $entity->getImage();
        foreach ($this->reader->getUploaderFields($entity) as $property => $annotation) {
            $this->handler->persist($media, $annotation);
        }
    }

    public function ideogrammeUpdate(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        $media = $entity->getImage();

        if (null !== $media->getImageFile()) {
            $entity = $event->getEntityInstance();
            foreach ($this->reader->getUploaderFields($entity) as $property => $annotation) {
                $this->handler->update($media, $annotation);
            }
        }
    }

    public function ideogrammeDelete(BeforeEntityDeletedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        $media = $entity->getImage();

        $this->handler->remove($media);
    }
}
