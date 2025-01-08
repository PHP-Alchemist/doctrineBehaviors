<?php

namespace PHPAlchemist\DoctrineBehaviors\Event\Listener;

use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class DoctrineBehaviorsListener
{
    public function __construct(private Security $security)
    {
    }

    protected function getUser() : ?UserInterface
    {
        $user = $this->security->getUser();

        if (!$user instanceof UserInterface) {
            return null;
        }

        return $user;
    }

    protected function getUnitOfWork(LifecycleEventArgs $lifecycleEventArgs) : UnitOfWork
    {
        $objectManager = $lifecycleEventArgs->getObjectManager();

        return $objectManager->getUnitOfWork();
    }

}