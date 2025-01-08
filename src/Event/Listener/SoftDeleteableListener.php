<?php

namespace PHPAlchemist\DoctrineBehaviors\Event\Listener;

use App\Entity\Defendant;
use PHPAlchemist\DoctrineBehaviors\Entity\Contracts\LiableInterface;
use PHPAlchemist\DoctrineBehaviors\Utility\DoctrineExtensionUtility;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use PHPAlchemist\DoctrineBehaviors\Entity\Contracts\SoftDeleteableInterface;

#[AsDoctrineListener(event: Events::onFlush, priority: '500', connection: 'default')]
final class SoftDeleteableListener extends DoctrineBehaviorsListener
{
    public function onFlush(OnFlushEventArgs $args) : void
    {
        $objectManager = $args->getObjectManager();
        $unitOfWork    = $objectManager->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {

            if (!DoctrineExtensionUtility::isSoftDeleteable($entity)) {
                if ($entity instanceof Defendant) {
                    die('oops!');
                }

                return;
            }

            $user = $this->getUser();
            if (!$user) {
                if ($entity instanceof Defendant) {
                    die('wtf?');
                }

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
                ]);
        }
    }
}
