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

namespace Evrinoma\FeedbackBundle\Factory\Feedback;

use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Entity\Feedback\BaseFeedback;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;

class Factory implements FactoryInterface
{
    private static string $entityClass = BaseFeedback::class;

    public function __construct(string $entityClass)
    {
        self::$entityClass = $entityClass;
    }

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     */
    public function create(FeedbackApiDtoInterface $dto): FeedbackInterface
    {
        /* @var BaseFeedback $feedback */
        return new self::$entityClass();
    }
}
