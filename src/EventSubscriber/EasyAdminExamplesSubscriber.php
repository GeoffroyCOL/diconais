<?php

namespace App\EventSubscriber;

use App\Handler\IdeogrammeHandler;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
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
            AfterEntityDeletedEvent::class => ['ideogrammeDelete']
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

    public function ideogrammeDelete(AfterEntityDeletedEvent $event): void
    {
        $entity = $event->getEntityInstance();
        $this->ideogrammeHandler->deleteExample($entity);
    }
}
