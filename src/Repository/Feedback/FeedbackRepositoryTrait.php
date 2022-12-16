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
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeSavedException;
use Evrinoma\FeedbackBundle\Exception\FeedbackNotFoundException;
use Evrinoma\FeedbackBundle\Exception\FeedbackProxyException;
use Evrinoma\FeedbackBundle\Mediator\QueryMediatorInterface;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;

trait FeedbackRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param FeedbackInterface $feedback
     *
     * @return bool
     *
     * @throws FeedbackCannotBeSavedException
     * @throws ORMException
     */
    public function save(FeedbackInterface $feedback): bool
    {
        try {
            $this->persistWrapped($feedback);
        } catch (ORMInvalidArgumentException $e) {
            throw new FeedbackCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param FeedbackInterface $feedback
     *
     * @return bool
     */
    public function remove(FeedbackInterface $feedback): bool
    {
        $feedback
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActiveToDelete();

        return true;
    }

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return array
     *
     * @throws FeedbackNotFoundException
     */
    public function findByCriteria(FeedbackApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $feedbacks = $this->mediator->getResult($dto, $builder);

        if (0 === \count($feedbacks)) {
            throw new FeedbackNotFoundException('Cannot find feedback by findByCriteria');
        }

        return $feedbacks;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws FeedbackNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): FeedbackInterface
    {
        /** @var FeedbackInterface $feedback */
        $feedback = $this->findWrapped($id);

        if (null === $feedback) {
            throw new FeedbackNotFoundException("Cannot find feedback with id $id");
        }

        return $feedback;
    }

    /**
     * @param string $id
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackProxyException
     * @throws ORMException
     */
    public function proxy(string $id): FeedbackInterface
    {
        $feedback = $this->referenceWrapped($id);

        if (!$this->containsWrapped($feedback)) {
            throw new FeedbackProxyException("Proxy doesn't exist with $id");
        }

        return $feedback;
    }
}
