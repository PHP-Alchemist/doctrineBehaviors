<?php

namespace PHPAlchemist\Doctrine\BehaviorsBundle;

use PHPAlchemist\Doctrine\BehaviorsBundle\Contract\DecisionServiceInterface;
use PHPAlchemist\Doctrine\BehaviorsBundle\Event\Listener\LiableEventListener;
use PHPAlchemist\Doctrine\BehaviorsBundle\Event\Listener\SoftDeleteableListener;
use PHPAlchemist\Doctrine\BehaviorsBundle\Event\Listener\TimestampableEventListener;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServiceConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class PHPAlchemistDoctrineBehaviorsBundle extends AbstractBundle
{
    /**
     * Config key => the listener it controls.
     *
     * 'name' is the value the listener passes to DecisionServiceInterface::decide(),
     * which is not always the config key (soft_deleteable vs soft-deleteable).
     */
    private const BEHAVIORS = [
        'liable'          => [
            'name'  => LiableEventListener::NAME,
            'id'    => 'php_alchemist.doctrine_behaviors.listener.liable',
            'class' => LiableEventListener::class,
        ],
        'timestampable'   => [
            'name'  => TimestampableEventListener::NAME,
            'id'    => 'php_alchemist.doctrine_behaviors.listener.timestampable',
            'class' => TimestampableEventListener::class,
        ],
        'soft_deleteable' => [
            'name'  => SoftDeleteableListener::NAME,
            'id'    => 'php_alchemist.doctrine_behaviors.listener.softdeletable',
            'class' => SoftDeleteableListener::class,
        ],
    ];

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder) : void
    {
        $container->import(__DIR__.'/Resources/config/services.php');

        $enabled = [];
        foreach (self::BEHAVIORS as $key => $behavior) {
            if ($config['behaviors'][$key]) {
                $enabled[$behavior['name']] = true;

                continue;
            }

            // Drop the listener outright rather than letting it no-op at runtime:
            // no service, no event tag, no decide() call on every flush.
            $enabled[$behavior['name']] = false;
            $builder->removeDefinition($behavior['id']);
            $builder->removeAlias($behavior['class']);
        }

        /** @var ServiceConfigurator $definition */
        $definition = $container->services()->get('php_alchemist.doctrine_behaviors.decision_service');
        if (null !== $config['decision_service'] && '' !== $config['decision_service']) {
            $definition->class($config['decision_service']);
            $definition->autowire(true);
            $definition->alias(DecisionServiceInterface::class, 'php_alchemist.doctrine_behaviors.decision_service');

            return;
        }

        // Only the bundle's own DecisionService takes $enabled; a custom class
        // owns its own constructor.
        $definition->arg('$enabled', $enabled);
    }

    public function configure(DefinitionConfigurator $definition) : void
    {
        $definition->rootNode()
                    ->children()
                        ->stringNode('decision_service')->defaultNull()->end()
                        ->arrayNode('behaviors')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('liable')->defaultTrue()->end()
                                ->booleanNode('timestampable')->defaultTrue()->end()
                                ->booleanNode('soft_deleteable')->defaultTrue()->end()
                            ->end()
                        ->end() // behaviors
                    ->end() // children
                   ->end();
    }
}
