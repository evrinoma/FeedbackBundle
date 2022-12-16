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

namespace Evrinoma\FeedbackBundle;

use Evrinoma\FeedbackBundle\DependencyInjection\Compiler\Constraint\Property\FeedbackPass;
use Evrinoma\FeedbackBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\FeedbackBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\FeedbackBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\FeedbackBundle\DependencyInjection\EvrinomaFeedbackExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaFeedbackBundle extends Bundle
{
    public const BUNDLE = 'feedback';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
            ->addCompilerPass(new FeedbackPass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaFeedbackExtension();
        }

        return $this->extension;
    }
}
