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

namespace Evrinoma\FeedbackBundle\Dto\Preserve;

use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\BodyInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ImageInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\PreviewInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\TitleInterface;

interface FeedbackApiDtoInterface extends IdInterface, ImageInterface, BodyInterface, TitleInterface, PositionInterface, ActiveInterface, PreviewInterface
{
}
