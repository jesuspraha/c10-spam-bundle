<?php

namespace C10\SpamBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('c10_spam');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('api_url')->isRequired()->end()
                ->scalarNode('api_source')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
