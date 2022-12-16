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

namespace Evrinoma\FeedbackBundle\Model\Feedback;

use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\BodyInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\UtilsBundle\Entity\PositionInterface;
use Evrinoma\UtilsBundle\Entity\TitleInterface;

interface FeedbackInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface, BodyInterface, TitleInterface, PositionInterface
{
    public function getPreview(): string;
    public function setPreview(string $preview): FeedbackInterface;
    public function getImage(): string;
    public function setImage(string $image): FeedbackInterface;
}
