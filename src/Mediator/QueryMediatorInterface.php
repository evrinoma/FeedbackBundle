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
use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param FeedbackApiDtoInterface $dto
     * @param QueryBuilderInterface    $builder
     *
     * @return mixed
     */
    public function createQuery(FeedbackApiDtoInterface $dto, QueryBuilderInterface $builder): void;

    /**
     * @param FeedbackApiDtoInterface $dto
     * @param QueryBuilderInterface    $builder
     *
     * @return array
     */
    public function getResult(FeedbackApiDtoInterface $dto, QueryBuilderInterface $builder): array;
}
