<?php

namespace Skwi\Bundle\ProjectBaseBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('skwi_project_base');

        $rootNode
            ->children()
            ->scalarNode('entity_bundle_name')->isRequired()->end()
            ->scalarNode('entity_bundle_namespace')->isRequired()->end()
            // ->scalarNode('object_manager')->end()
            ->scalarNode('kernel_root_dir')->isRequired()->end()
            ->scalarNode('password_encoder')->end()
            ->scalarNode('pager_max_per_page')->end()
            ->end()
            ;

        return $treeBuilder;
    }
}
