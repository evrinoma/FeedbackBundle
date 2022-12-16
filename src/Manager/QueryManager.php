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
use Evrinoma\FeedbackBundle\Repository\Feedback\FeedbackQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private FeedbackQueryRepositoryInterface $repository;

    public function __construct(FeedbackQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return array
     *
     * @throws FeedbackNotFoundException
     */
    public function criteria(FeedbackApiDtoInterface $dto): array
    {
        try {
            $feedback = $this->repository->findByCriteria($dto);
        } catch (FeedbackNotFoundException $e) {
            throw $e;
        }

        return $feedback;
    }

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackProxyException
     */
    public function proxy(FeedbackApiDtoInterface $dto): FeedbackInterface
    {
        try {
            if ($dto->hasId()) {
                $feedback = $this->repository->proxy($dto->idToString());
            } else {
                throw new FeedbackProxyException('Id value is not set while trying get proxy object');
            }
        } catch (FeedbackProxyException $e) {
            throw $e;
        }

        return $feedback;
    }

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackNotFoundException
     */
    public function get(FeedbackApiDtoInterface $dto): FeedbackInterface
    {
        try {
            $feedback = $this->repository->find($dto->idToString());
        } catch (FeedbackNotFoundException $e) {
            throw $e;
        }

        return $feedback;
    }
}
