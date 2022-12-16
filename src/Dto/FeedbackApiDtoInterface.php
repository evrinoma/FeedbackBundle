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

namespace Evrinoma\FeedbackBundle\Dto;

use Evrinoma\FeedbackBundle\DtoCommon\ValueObject\Immutable\ImageInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\BodyInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\PositionInterface;
use Evrinoma\DtoCommon\ValueObject\Immutable\TitleInterface;
use Evrinoma\FeedbackBundle\DtoCommon\ValueObject\Immutable\PreviewInterface;

interface FeedbackApiDtoInterface extends DtoInterface, IdInterface, ImageInterface, TitleInterface, BodyInterface, PositionInterface, ActiveInterface, PreviewInterface
{
}
