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

namespace Evrinoma\FeedbackBundle\Factory;

use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;

interface FeedbackFactoryInterface
{
    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     */
    public function create(FeedbackApiDtoInterface $dto): FeedbackInterface;
}
