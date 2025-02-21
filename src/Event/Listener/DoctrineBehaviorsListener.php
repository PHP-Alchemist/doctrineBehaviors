<?php

namespace PHPAlchemist\DoctrineBehaviors\Event\Listener;

use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use http\Encoding\Stream\Debrotli;
use PHPAlchemist\DoctrineBehaviors\Contract\DecisionServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class DoctrineBehaviorsListener
{
    protected ?DecisionServiceInterface $decisionService;

    public function __construct(private Security $security)
    {
    }

    public function setDecisionService(DecisionServiceInterface $decisionService) : void
    {
        $this->decisionService = $decisionService;
    }

    protected function confirmExecutable(string $service) : bool
    {
        if (isset($this->decisionService) && $this->decisionService->decide($service)) {
            return true;
        }

        return false;
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