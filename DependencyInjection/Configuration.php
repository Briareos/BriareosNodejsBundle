<?php

namespace Briareos\NodejsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('briareos_nodejs');

        $rootNode
            ->children()
                ->arrayNode('dispatcher')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('secure')->defaultFalse()->end()
                        ->scalarNode('host')->defaultValue('localhost')->end()
                        ->scalarNode('port')->defaultValue(8080)
                            ->validate()
                                ->ifTrue(function($v) {
                                    return !is_int($v) || ($v < 1) || ($v > 65535);
                                })
                                ->thenInvalid('Must be a number between 1 and 65535')
                            ->end()
                        ->end()
                        ->scalarNode('resource')->defaultValue('/socket.io')->end()
                        ->scalarNode('service_key')->defaultValue('')->end()
                        ->scalarNode('connect_timeout')->defaultValue(5000)->end()
                    ->end()
                ->end()
                ->arrayNode('authenticator')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('lifetime')->defaultValue(900)->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }


}
