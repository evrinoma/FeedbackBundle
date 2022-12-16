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

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Exception\FeedbackNotFoundException;
use Evrinoma\FeedbackBundle\Exception\FeedbackProxyException;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;

interface FeedbackQueryRepositoryInterface
{
    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return array
     *
     * @throws FeedbackNotFoundException
     */
    public function findByCriteria(FeedbackApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): FeedbackInterface;

    /**
     * @param string $id
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackProxyException
     * @throws ORMException
     */
    public function proxy(string $id): FeedbackInterface;
}
