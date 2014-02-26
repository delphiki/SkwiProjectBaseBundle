<?php

namespace Skwi\Bundle\ProjectBaseBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class SkwiProjectBaseExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        //Base Manager
        $container->setParameter('skwi.projectbase.config.kernel_root_dir', $config['kernel_root_dir']);
        // $container->setParameter('skwi.projectbase.config.object_manager', $config['object_manager']);
        $container->setParameter('skwi.projectbase.config.entity_bundle_name', $config['entity_bundle_name']);
        $container->setParameter('skwi.projectbase.config.entity_bundle_namespace', $config['entity_bundle_namespace']);

        //Encoder
        $container->setParameter('skwi.projectbase.config.password_encoder', $config['password_encoder']);

        //Pager
        $container->setParameter('skwi.projectbase.config.pager_max_per_page', $config['pager_max_per_page']);

    }
}
