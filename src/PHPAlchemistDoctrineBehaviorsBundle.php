<?php

namespace PHPAlchemist\Bundle\DoctrineBehaviors;

use PHPAlchemist\Bundle\DoctrineBehaviors\Contract\DecisionServiceInterface;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PHPAlchemistDoctrineBehaviorsBundle extends AbstractBundle
{

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder) : void
    {
        $loader = new XmlFileLoader($builder, new FileLocator(__DIR__ . '/Resources/config'));
        $loader->load('services.xml');

        /** @var ServiceConfigurator $definition */
        $definition = $container->services()->get('php_alchemist.doctrine_behaviors.decision_service');
        if (null !== $config['decision_service'] && '' !== $config['decision_service']) {
            $definition->class($config['decision_service']);
            $definition->autowire(true);
            $definition->alias(DecisionServiceInterface::class, 'php_alchemist.doctrine_behaviors.decision_service');
        }
    }

    public function configure(DefinitionConfigurator $definition) : void
    {

        $definition->rootNode()
                    ->children()
                        ->stringNode('decision_service')->defaultNull()->end()
                    ->end() // children
                   ->end()
        ;
    }

}