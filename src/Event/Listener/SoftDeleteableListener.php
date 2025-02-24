<?php

namespace PHPAlchemist\Bundle\DoctrineBehaviors\Event\Listener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use PHPAlchemist\Bundle\DoctrineBehaviors\Entity\Contracts\LiableInterface;
use PHPAlchemist\Bundle\DoctrineBehaviors\Entity\Contracts\SoftDeleteableInterface;
use PHPAlchemist\Bundle\DoctrineBehaviors\Utility\DoctrineExtensionUtility;

#[AsDoctrineListener(event: Events::onFlush, priority: '500', connection: 'default')]
final class SoftDeleteableListener extends DoctrineBehaviorsListener
{
    const string NAME = 'soft-deleteable';

    public function onFlush(OnFlushEventArgs $args) : void
    {
        if (!$this->confirmExecutable(self::NAME)) {
            return;
        }

        $objectManager = $args->getObjectManager();
        $unitOfWork    = $objectManager->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
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

            // This should not be necessary - unsure why preRemove is being overwritten
            $oldDeletedBy = $entity->getDeletedBy();
            $entity->setDeletedBy($user);

            $objectManager->persist($entity);
            $unitOfWork->propertyChanged(
                $entity,
                LiableInterface::DELETED_BY,
                $oldDeletedBy,
                $entity->getDeletedBy(),
            );
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
                    LiableInterface::DELETED_BY         => [
                        $oldDeletedBy,
                        $entity->getDeletedBy(),
                    ],
                ]
            );
        }
    }
}
