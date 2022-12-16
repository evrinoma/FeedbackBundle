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

namespace Evrinoma\FeedbackBundle\Manager;

use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeRemovedException;
use Evrinoma\FeedbackBundle\Exception\FeedbackInvalidException;
use Evrinoma\FeedbackBundle\Exception\FeedbackNotFoundException;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;

interface CommandManagerInterface
{
    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackInvalidException
     */
    public function post(FeedbackApiDtoInterface $dto): FeedbackInterface;

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackInvalidException
     * @throws FeedbackNotFoundException
     */
    public function put(FeedbackApiDtoInterface $dto): FeedbackInterface;

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @throws FeedbackCannotBeRemovedException
     * @throws FeedbackNotFoundException
     */
    public function delete(FeedbackApiDtoInterface $dto): void;
}
