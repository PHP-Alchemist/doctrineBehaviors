<?php

namespace App\Event\Listener;

use App\Utility\DoctrineExtensionUtility;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use PHPAlchemist\DoctrineBehaviors\Contracts\LiableInterface;
use Doctrine\ORM\Event\{PrePersistEventArgs, PreRemoveEventArgs, PreUpdateEventArgs};
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::prePersist, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preUpdate, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preRemove, priority: 500, connection: 'default')]
final class LiableEventListener extends DoctrineBehaviorsListener
{
    public function prePersist(PrePersistEventArgs $args) : void
    {
        $unitOfWork = $this->getUnitOfWork($args);
        $entity     = $args->getObject();

        if (!DoctrineExtensionUtility::isLiable($entity)) {
            return;
        }

        $user = $this->getUser();
        if (!$user) {
            return;
        }

        if (null === $entity->getCreatedBy()) {
            $entity->setCreatedBy($user);

            $unitOfWork->propertyChanged(
                $entity,
                LiableInterface::CREATED_BY,
                null,
                $user
            );
        }
    }

    public function preUpdate(PreUpdateEventArgs $args) : void
    {
        $unitOfWork = $this->getUnitOfWork($args);
        $entity     = $args->getObject();

        if (!DoctrineExtensionUtility::isLiable($entity)) {
            return;
        }

        $user = $this->getUser();
        if (!$user) {
            return;
        }

        $oldUpdatedByValue = $entity->getUpdatedBy();
        $entity->setUpdatedBy($user);
        $unitOfWork->propertyChanged(
            $entity,
            LiableInterface::UPDATED_BY,
            $oldUpdatedByValue,
            $user
        );
    }

    public function preRemove(PreRemoveEventArgs $preRemoveEventArgs) : void
    {
        $unitOfWork = $this->getUnitOfWork($preRemoveEventArgs);
        $entity     = $preRemoveEventArgs->getObject();

        if (
            !DoctrineExtensionUtility::isLiable($entity) ||
            DoctrineExtensionUtility::isSoftDeleteable($entity)
        ) {
            return;
        }

        $user = $this->getUser();
        if (!$user) {
            return;
        }

        $oldDeletedByValue = $entity->getDeletedBy();
        $entity->setDeletedBy($user);
        $unitOfWork->propertyChanged(
            $entity,
            LiableInterface::DELETED_BY,
            $oldDeletedByValue,
            $user
        );
    }

}
