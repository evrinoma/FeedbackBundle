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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Exception\FeedbackInvalidException;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkBody($dto)
            ->checkImage($dto)
            ->checkPreview($dto)
            ->checkTitle($dto)
            ->checkPosition($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkId($dto)
            ->checkBody($dto)
            ->checkImage($dto)
            ->checkPreview($dto)
            ->checkTitle($dto)
            ->checkActive($dto)
            ->checkPosition($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this
            ->checkId($dto);
    }

    protected function checkPosition(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasPosition()) {
            throw new FeedbackInvalidException('The Dto has\'t position');
        }

        return $this;
    }

    protected function checkTitle(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasTitle()) {
            throw new FeedbackInvalidException('The Dto has\'t title');
        }

        return $this;
    }

    protected function checkActive(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new FeedbackInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    protected function checkImage(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasImage()) {
            throw new FeedbackInvalidException('The Dto has\'t Image file');
        }

        return $this;
    }

    protected function checkPreview(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasPreview()) {
            throw new FeedbackInvalidException('The Dto has\'t Preview file');
        }

        return $this;
    }

    protected function checkBody(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasBody()) {
            throw new FeedbackInvalidException('The Dto has\'t body');
        }

        return $this;
    }

    protected function checkId(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new FeedbackInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
