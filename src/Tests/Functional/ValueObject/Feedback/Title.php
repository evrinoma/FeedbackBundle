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

namespace Evrinoma\FeedbackBundle\Tests\Functional\ValueObject\Feedback;

use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractIdentity;

class Title extends AbstractIdentity
{
    protected static string $value = 'nvr';
    protected static string $default = 'kpz';
}
