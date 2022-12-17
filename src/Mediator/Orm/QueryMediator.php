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

namespace Evrinoma\FeedbackBundle\Mediator\Orm;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Mediator\QueryMediatorInterface;
use Evrinoma\FeedbackBundle\Repository\AliasInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractQueryMediator;
use Evrinoma\UtilsBundle\Mediator\Orm\QueryMediatorTrait;
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

class QueryMediator extends AbstractQueryMediator implements QueryMediatorInterface
{
    use QueryMediatorTrait;

    protected static string $alias = AliasInterface::FEEDBACK;

    /**
     * @param DtoInterface          $dto
     * @param QueryBuilderInterface $builder
     *
     * @return mixed
     */
    public function createQuery(DtoInterface $dto, QueryBuilderInterface $builder): void
    {
        $alias = $this->alias();

        /** @var $dto FeedbackApiDtoInterface */
        if ($dto->hasId()) {
            $builder
                ->andWhere($alias.'.id = :id')
                ->setParameter('id', $dto->getId());
        }

        if ($dto->hasBody()) {
            $builder
                ->andWhere($alias.'.body like :body')
                ->setParameter('body', '%'.$dto->getBody().'%');
        }

        if ($dto->hasTitle()) {
            $builder
                ->andWhere($alias.'.title like :title')
                ->setParameter('title', '%'.$dto->getTitle().'%');
        }

        if ($dto->hasPosition()) {
            $builder
                ->andWhere($alias.'.position = :position')
                ->setParameter('position', $dto->getPosition());
        }

        if ($dto->hasActive()) {
            $builder
                ->andWhere($alias.'.active = :active')
                ->setParameter('active', $dto->getActive());
        }
    }
}
