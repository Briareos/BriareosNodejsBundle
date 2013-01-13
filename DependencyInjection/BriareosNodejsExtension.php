<?php

namespace Briareos\NodejsBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BriareosNodejsExtension extends Extension
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

        $container->setParameter('nodejs.dispatcher.secure',$config['dispatcher']['secure']);
        $container->setParameter('nodejs.dispatcher.host',$config['dispatcher']['host']);
        $container->setParameter('nodejs.dispatcher.port',$config['dispatcher']['port']);
        $container->setParameter('nodejs.dispatcher.port',$config['dispatcher']['port']);
        $container->setParameter('nodejs.dispatcher.resource',$config['dispatcher']['resource']);
        $container->setParameter('nodejs.dispatcher.service_key',$config['dispatcher']['service_key']);
        $container->setParameter('nodejs.dispatcher.connect_timeout',$config['dispatcher']['connect_timeout']);

        $container->setParameter('nodejs.authenticator.lifetime',$config['authenticator']['lifetime']);

    }
}
