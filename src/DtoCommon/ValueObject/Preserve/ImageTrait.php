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

namespace Evrinoma\FeedbackBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\File\File;

trait ImageTrait
{
    /**
     * @param File $image
     *
     * @return DtoInterface
     */
    public function setImage(File $image): DtoInterface
    {
        return parent::setImage($image);
    }
}
