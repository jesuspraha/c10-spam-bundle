<?php

namespace C10\SpamBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class C10SpamExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('c10_spam.api_url', $config['api_url']);
        $container->setParameter('c10_spam.api_source', $config['api_source']);

        $container->register('c10_spam.classifier', 'C10\SpamBundle\Service\SpamClassifierApi')
            ->setArguments([
                new Reference('http_client'),
                '%c10_spam.api_url%',
                '%c10_spam.api_source%',
            ]);
    }
}
