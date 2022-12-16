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

namespace Evrinoma\FeedbackBundle\DependencyInjection\Compiler\Constraint\Property;

use Evrinoma\FeedbackBundle\Validator\FeedbackValidator;
use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class FeedbackPass extends AbstractConstraint implements CompilerPassInterface
{
    public const FEEDBACK_CONSTRAINT = 'evrinoma.feedback.constraint.property';

    protected static string $alias = self::FEEDBACK_CONSTRAINT;
    protected static string $class = FeedbackValidator::class;
    protected static string $methodCall = 'addPropertyConstraint';
}
