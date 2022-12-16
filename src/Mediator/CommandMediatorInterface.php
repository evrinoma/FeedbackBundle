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

namespace Evrinoma\FeedbackBundle\Mediator;

use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeCreatedException;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeRemovedException;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeSavedException;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;

interface CommandMediatorInterface
{
    /**
     * @param FeedbackApiDtoInterface $dto
     * @param FeedbackInterface       $entity
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackCannotBeSavedException
     */
    public function onUpdate(FeedbackApiDtoInterface $dto, FeedbackInterface $entity): FeedbackInterface;

    /**
     * @param FeedbackApiDtoInterface $dto
     * @param FeedbackInterface       $entity
     *
     * @throws FeedbackCannotBeRemovedException
     */
    public function onDelete(FeedbackApiDtoInterface $dto, FeedbackInterface $entity): void;

    /**
     * @param FeedbackApiDtoInterface $dto
     * @param FeedbackInterface       $entity
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackCannotBeSavedException
     * @throws FeedbackCannotBeCreatedException
     */
    public function onCreate(FeedbackApiDtoInterface $dto, FeedbackInterface $entity): FeedbackInterface;
}
