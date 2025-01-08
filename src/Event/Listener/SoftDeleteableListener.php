<?php

namespace PHPAlchemist\DoctrineBehaviors\Event\Listener;

use PHPAlchemist\DoctrineBehaviors\Utility\DoctrineExtensionUtility;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\{PreRemoveEventArgs};
use Doctrine\ORM\Events;
use PHPAlchemist\DoctrineBehaviors\Entity\Contracts\SoftDeleteableInterface;

// # [- AsDoctrineListener(event: Events::preRemove, priority: 500, connection: 'default')]
#[AsDoctrineListener(event: Events::preRemove, priority: '500', connection: 'default')]
final class SoftDeleteableListener extends DoctrineBehaviorsListener
{
    public function preRemove(PreRemoveEventArgs $preRemoveEventArgs) : void
    {
        $unitOfWork    = $this->getUnitOfWork($preRemoveEventArgs);
        $objectManager = $preRemoveEventArgs->getObjectManager();

        $entity = $preRemoveEventArgs->getObject();
        if (!DoctrineExtensionUtility::isSoftDeleteable($entity)) {
            return;
        }

        $user = $this->getUser();
        if (!$user) {
            return;
        }

        $oldDeletedAt = $entity->getDeletedAt();
        $newDeletedAt = new \DateTime();
        $entity->setDeletedAt($newDeletedAt);
        $objectManager->persist($entity);
        $entity->setDeletedAt($newDeletedAt);

        $unitOfWork->propertyChanged(
            $entity,
            SoftDeleteableInterface::DELETED_AT,
            $oldDeletedAt,
            $newDeletedAt
        );
        $unitOfWork->scheduleExtraUpdate(
            $entity,
            [
                SoftDeleteableInterface::DELETED_AT => [
                    $oldDeletedAt,
                    $entity->getDeletedAt(),
                ],
            ]);
    }
}