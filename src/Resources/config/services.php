<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use PHPAlchemist\Doctrine\BehaviorsBundle\Contract\DecisionServiceInterface;
use PHPAlchemist\Doctrine\BehaviorsBundle\Event\Listener\LiableEventListener;
use PHPAlchemist\Doctrine\BehaviorsBundle\Event\Listener\SoftDeleteableListener;
use PHPAlchemist\Doctrine\BehaviorsBundle\Event\Listener\TimestampableEventListener;
use PHPAlchemist\Doctrine\BehaviorsBundle\Service\DecisionService;
use Symfony\Bundle\SecurityBundle\Security;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    // DecisionService
    $services->set('php_alchemist.doctrine_behaviors.decision_service', DecisionService::class)
        ->public();

    $services->alias(DecisionService::class, 'php_alchemist.doctrine_behaviors.decision_service')
        ->public();

    $services->alias(DecisionServiceInterface::class, DecisionService::class)
        ->public();

    // Liable
    $services->set('php_alchemist.doctrine_behaviors.listener.liable', LiableEventListener::class)
        ->arg('$security', service(Security::class))
        ->call('setDecisionService', [service('php_alchemist.doctrine_behaviors.decision_service')]);

    $services->alias(LiableEventListener::class, 'php_alchemist.doctrine_behaviors.listener.liable');

    // Timestampable
    $services->set('php_alchemist.doctrine_behaviors.listener.timestampable', TimestampableEventListener::class)
        ->arg('$security', service(Security::class))
        ->call('setDecisionService', [service('php_alchemist.doctrine_behaviors.decision_service')]);

    $services->alias(TimestampableEventListener::class, 'php_alchemist.doctrine_behaviors.listener.timestampable');

    // SoftDeleteable
    $services->set('php_alchemist.doctrine_behaviors.listener.softdeletable', SoftDeleteableListener::class)
        ->arg('$security', service(Security::class))
        ->call('setDecisionService', [service('php_alchemist.doctrine_behaviors.decision_service')]);

    $services->alias(SoftDeleteableListener::class, 'php_alchemist.doctrine_behaviors.listener.softdeletable');
};
