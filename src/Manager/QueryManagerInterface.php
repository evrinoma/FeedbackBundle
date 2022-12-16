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
use Evrinoma\FeedbackBundle\Exception\FeedbackNotFoundException;
use Evrinoma\FeedbackBundle\Exception\FeedbackProxyException;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;

interface QueryManagerInterface
{
    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return array
     *
     * @throws FeedbackNotFoundException
     */
    public function criteria(FeedbackApiDtoInterface $dto): array;

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackNotFoundException
     */
    public function get(FeedbackApiDtoInterface $dto): FeedbackInterface;

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackProxyException
     */
    public function proxy(FeedbackApiDtoInterface $dto): FeedbackInterface;
}
