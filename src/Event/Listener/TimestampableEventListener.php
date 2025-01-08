<?php

namespace App\Event\Listener;

use App\Utility\DoctrineExtensionUtility;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;
use PHPAlchemist\DoctrineBehaviors\Contracts\TimeStampableInterface;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
final class TimestampableEventListener extends DoctrineBehaviorsListener
{
    public function prePersist(PrePersistEventArgs $args) : void
    {
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
        $unitOfWork = $this->getUnitOfWork($args);
        $entity     = $args->getObject();

        if (!DoctrineExtensionUtility::isTimeStampable($entity)) {
            die('You Should not see me');

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
