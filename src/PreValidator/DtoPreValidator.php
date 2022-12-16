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
use Evrinoma\DtoBundle\Dto\DtoInterface;
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

    private function checkPosition(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasPosition()) {
            throw new FeedbackInvalidException('The Dto has\'t position');
        }

        return $this;
    }

    private function checkTitle(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasTitle()) {
            throw new FeedbackInvalidException('The Dto has\'t title');
        }

        return $this;
    }

    private function checkActive(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new FeedbackInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    private function checkImage(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasImage()) {
            throw new FeedbackInvalidException('The Dto has\'t Image file');
        }

        return $this;
    }

    private function checkPreview(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasPreview()) {
            throw new FeedbackInvalidException('The Dto has\'t Preview file');
        }

        return $this;
    }

    private function checkBody(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasBody()) {
            throw new FeedbackInvalidException('The Dto has\'t body');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var FeedbackApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new FeedbackInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
