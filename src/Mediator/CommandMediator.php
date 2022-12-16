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
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;
use Evrinoma\FeedbackBundle\System\FileSystemInterface;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    private FileSystemInterface $fileSystem;

    public function __construct(FileSystemInterface $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function onUpdate(DtoInterface $dto, $entity): FeedbackInterface
    {
        /* @var $dto FeedbackApiDtoInterface */
        $fileImage = $this->fileSystem->save($dto->getImage());
        $filePreview = $this->fileSystem->save($dto->getPreview());
        $entity
            ->setTitle($dto->getTitle())
            ->setPosition($dto->getPosition())
            ->setBody($dto->getBody())
            ->setImage($fileImage->getRealPath())
            ->setPreview($filePreview->getRealPath())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): FeedbackInterface
    {
        /* @var $dto FeedbackApiDtoInterface */
        $fileImage = $this->fileSystem->save($dto->getImage());
        $filePreview = $this->fileSystem->save($dto->getPreview());
        $entity
            ->setTitle($dto->getTitle())
            ->setPosition($dto->getPosition())
            ->setBody($dto->getBody())
            ->setImage($fileImage->getRealPath())
            ->setPreview($filePreview->getRealPath())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        return $entity;
    }
}
