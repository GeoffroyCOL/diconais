<?php

namespace App\EventSubscriber;

use App\Handler\IdeogrammeHandler;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;

class EasyAdminExamplesSubscriber implements EventSubscriberInterface
{
    public function __construct(private IdeogrammeHandler $ideogrammeHandler)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            BeforeEntityPersistedEvent::class => ['ideogrammePersist'],
            BeforeEntityUpdatedEvent::class => ['ideogrammeUpdate'],
        ];
    }

    public function ideogrammePersist(BeforeEntityPersistedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        $this->ideogrammeHandler->addExamples($entity);
    }

    public function ideogrammeUpdate(BeforeEntityUpdatedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        $this->ideogrammeHandler->editExamples($entity);
    }
}
