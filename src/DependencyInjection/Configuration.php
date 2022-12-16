<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\FeedbackBundle\DependencyInjection;

use Evrinoma\FeedbackBundle\EvrinomaFeedbackBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaFeedbackBundle::BUNDLE);
        $rootNode = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(EvrinomaFeedbackExtension::ENTITY_FACTORY_FEEDBACK)->end()
            ->scalarNode('entity')->cannotBeEmpty()->defaultValue(EvrinomaFeedbackExtension::ENTITY_BASE_FEEDBACK)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used to enable/disable basic feedback constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaFeedbackExtension::DTO_BASE_FEEDBACK)->info('This option is used to dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used to command feedback decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used to query feedback decoration')->end()
            ->end()->end()
            ->arrayNode('services')->addDefaultsIfNotSet()->children()
            ->scalarNode('pre_validator')->defaultNull()->info('This option is used to pre_validator overriding')->end()
            ->scalarNode('handler')->cannotBeEmpty()->defaultValue(EvrinomaFeedbackExtension::HANDLER)->info('This option is used to handler override')->end()
            ->scalarNode('file_system')->defaultNull()->info('This option is used to file system override')->end()
            ->end()->end()
            ->end();

        return $treeBuilder;
    }
}
