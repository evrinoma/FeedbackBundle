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

namespace Evrinoma\FeedbackBundle\PreValidator;

use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Exception\FeedbackInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @throws FeedbackInvalidException
     */
    public function onPost(FeedbackApiDtoInterface $dto): void;

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @throws FeedbackInvalidException
     */
    public function onPut(FeedbackApiDtoInterface $dto): void;

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @throws FeedbackInvalidException
     */
    public function onDelete(FeedbackApiDtoInterface $dto): void;
}
