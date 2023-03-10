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

namespace Evrinoma\FeedbackBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\BodyTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\ImageTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\PreviewTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\TitleTrait;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;

class FeedbackApiDto extends AbstractDto implements FeedbackApiDtoInterface
{
    use ActiveTrait;
    use BodyTrait;
    use IdTrait;
    use ImageTrait;
    use PositionTrait;
    use PreviewTrait;
    use TitleTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id = $request->get(FeedbackApiDtoInterface::ID);
            $active = $request->get(FeedbackApiDtoInterface::ACTIVE);
            $title = $request->get(FeedbackApiDtoInterface::TITLE);
            $position = $request->get(FeedbackApiDtoInterface::POSITION);
            $body = $request->get(FeedbackApiDtoInterface::BODY);

            $files = ($request->files->has($this->getClass())) ? $request->files->get($this->getClass()) : [];

            try {
                if (\array_key_exists(FeedbackApiDtoInterface::IMAGE, $files)) {
                    $image = $files[FeedbackApiDtoInterface::IMAGE];
                } else {
                    $image = $request->get(FeedbackApiDtoInterface::IMAGE);
                    if (null !== $image) {
                        $image = new File($image);
                    }
                }
            } catch (\Exception $e) {
                $image = null;
            }

            try {
                if (\array_key_exists(FeedbackApiDtoInterface::PREVIEW, $files)) {
                    $preview = $files[FeedbackApiDtoInterface::PREVIEW];
                } else {
                    $preview = $request->get(FeedbackApiDtoInterface::PREVIEW);
                    if (null !== $preview) {
                        $preview = new File($preview);
                    }
                }
            } catch (\Exception $e) {
                $preview = null;
            }

            if ($active) {
                $this->setActive($active);
            }
            if ($id) {
                $this->setId($id);
            }
            if ($position) {
                $this->setPosition($position);
            }
            if ($title) {
                $this->setTitle($title);
            }
            if ($body) {
                $this->setBody($body);
            }
            if ($image) {
                $this->setImage($image);
            }
            if ($preview) {
                $this->setPreview($preview);
            }
        }

        return $this;
    }
}
