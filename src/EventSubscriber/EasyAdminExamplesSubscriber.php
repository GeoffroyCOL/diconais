<?php

namespace App\EventSubscriber;

use App\Handler\IdeogrammeHandler;
use App\Uploader\Attribute\UploaderAttributeReader;
use App\Uploader\Handler\UploaderHandler;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminExamplesSubscriber implements EventSubscriberInterface
{
    public function __construct(private IdeogrammeHandler $ideogrammeHandler)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['ideogrammePersist'],
        ];
    }

    public function ideogrammePersist(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        $this->ideogrammeHandler->addExamples($entity);
    }
}
