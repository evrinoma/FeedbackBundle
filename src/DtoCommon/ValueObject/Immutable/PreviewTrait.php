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

trait PreviewTrait
{
    private ?File $preview = null;

    public function getPreview(): File
    {
        return $this->preview;
    }

    public function hasPreview(): bool
    {
        return null !== $this->preview;
    }
}
