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

namespace Evrinoma\FeedbackBundle\Repository\Feedback;

use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeRemovedException;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeSavedException;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;

interface FeedbackCommandRepositoryInterface
{
    /**
     * @param FeedbackInterface $feedback
     *
     * @return bool
     *
     * @throws FeedbackCannotBeSavedException
     */
    public function save(FeedbackInterface $feedback): bool;

    /**
     * @param FeedbackInterface $feedback
     *
     * @return bool
     *
     * @throws FeedbackCannotBeRemovedException
     */
    public function remove(FeedbackInterface $feedback): bool;
}
