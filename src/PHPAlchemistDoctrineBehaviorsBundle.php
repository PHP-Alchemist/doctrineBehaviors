<?php

namespace PHPAlchemist\DoctrineBehaviors;

use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;


class PHPAlchemistDoctrineBehaviorsBundle extends AbstractBundle
{
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder) : void
    {
        $container->import('../config/services.yaml');
    }
}