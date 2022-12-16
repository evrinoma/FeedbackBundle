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

namespace Evrinoma\FeedbackBundle\DtoCommon\ValueObject\Immutable;

use Symfony\Component\HttpFoundation\File\File;

interface PreviewInterface
{
    public const PREVIEW = 'preview';

    public function getPreview(): File;

    public function hasPreview(): bool;
}
