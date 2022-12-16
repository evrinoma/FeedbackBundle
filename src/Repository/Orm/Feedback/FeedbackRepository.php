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

namespace Evrinoma\FeedbackBundle\Repository\Orm\Feedback;

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\FeedbackBundle\Mediator\QueryMediatorInterface;
use Evrinoma\FeedbackBundle\Repository\Feedback\FeedbackRepositoryInterface;
use Evrinoma\FeedbackBundle\Repository\Feedback\FeedbackRepositoryTrait;
use Evrinoma\UtilsBundle\Repository\Orm\RepositoryWrapper;
use Evrinoma\UtilsBundle\Repository\RepositoryWrapperInterface;

class FeedbackRepository extends RepositoryWrapper implements FeedbackRepositoryInterface, RepositoryWrapperInterface
{
    use FeedbackRepositoryTrait;

    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }
}
