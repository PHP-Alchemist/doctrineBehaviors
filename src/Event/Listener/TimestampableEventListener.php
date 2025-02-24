<?php

namespace PHPAlchemist\Bundle\DoctrineBehaviors\Event\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use PHPAlchemist\Bundle\DoctrineBehaviors\Entity\Contracts\TimeStampableInterface;
use PHPAlchemist\Bundle\DoctrineBehaviors\Utility\DoctrineExtensionUtility;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
final class TimestampableEventListener extends DoctrineBehaviorsListener
{
    const string NAME = 'timestampable';

    public function prePersist(PrePersistEventArgs $args) : void
    {
        if (!$this->confirmExecutable(self::NAME)) {
            return;
        }

        $unitOfWork = $this->getUnitOfWork($args);
        $entity     = $args->getObject();

        if (!DoctrineExtensionUtility::isTimeStampable($entity)) {
            return;
        }

        if (null === $entity->getCreatedAt()) {
            $newUpdatedByValue = new \DateTime();
            $entity->setCreatedAt($newUpdatedByValue);

            $unitOfWork->propertyChanged(
                $entity,
                TimeStampableInterface::CREATED_AT,
                null,
                $newUpdatedByValue
            );
        }
    }

    public function preUpdate(PreUpdateEventArgs $args) : void
    {
        if (!$this->confirmExecutable(self::NAME)) {
            return;
        }

        $unitOfWork = $this->getUnitOfWork($args);
        $entity     = $args->getObject();

        if (!DoctrineExtensionUtility::isTimeStampable($entity)) {
            return;
        }

        $oldUpdatedByValue = $entity->getUpdatedAt();
        $newUpdatedByValue = new \DateTime();
        $entity->setUpdatedAt($newUpdatedByValue);
        $unitOfWork->propertyChanged(
            $entity,
            TimeStampableInterface::UPDATED_AT,
            $oldUpdatedByValue,
            $newUpdatedByValue
        );
    }
}
