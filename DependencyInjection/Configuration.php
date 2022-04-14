<?php

namespace MandarinMedien\MMCmfRoutingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('mm_cmf_routing');
        $rootNode = $treeBuilder->getRootNode();

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $this->addBundleConfig($rootNode);

        return $treeBuilder;
    }

    private function addBundleConfig(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('defaults')
                    ->children()
                        ->scalarNode('template')->end()
                    ->end()
                ->end()
                ->arrayNode('route_loader')
                    ->children()
                        ->arrayNode('_controllers')
                            ->children()
                                ->scalarNode('default')->end()
                                ->scalarNode('auto')->end()
                                ->scalarNode('alias')->end()
                                ->scalarNode('redirect')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ;
    }
}
