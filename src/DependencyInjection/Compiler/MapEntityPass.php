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

namespace Evrinoma\FeedbackBundle\DependencyInjection\Compiler;

use Evrinoma\FeedbackBundle\DependencyInjection\EvrinomaFeedbackExtension;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ('orm' === $container->getParameter('evrinoma.feedback.storage')) {
            $this->setContainer($container);

            $driver = $container->findDefinition('doctrine.orm.default_metadata_driver');
            $referenceAnnotationReader = new Reference('annotations.reader');

            $this->cleanMetadata($driver, [EvrinomaFeedbackExtension::ENTITY]);

            $entityFeedback = $container->getParameter('evrinoma.feedback.entity');
            if (str_contains($entityFeedback, EvrinomaFeedbackExtension::ENTITY)) {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/Feedback', '%s/Entity/Feedback');
            }
            $this->addResolveTargetEntity([$entityFeedback => [FeedbackInterface::class => []]], false);
        }
    }
}
