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

namespace Evrinoma\FeedbackBundle\Tests\Functional\Helper;

use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait BaseFeedbackTestTrait
{
    protected static function initFiles(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'http');

        file_put_contents($path, 'my_file');

        $fileImage = $filePreview = new UploadedFile($path, 'my_file');

        static::$files = [
            static::getDtoClass() => [
                FeedbackApiDtoInterface::IMAGE => $fileImage,
                FeedbackApiDtoInterface::PREVIEW => $filePreview,
                ],
        ];
    }

    protected function assertGet(string $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createFeedback(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createConstraintBlankName(): array
    {
        $query = static::getDefault([FeedbackApiDtoInterface::TITLE => '']);

        return $this->post($query);
    }

    protected function createConstraintBlankUrl(): array
    {
        $query = static::getDefault([FeedbackApiDtoInterface::BODY => '']);

        return $this->post($query);
    }

    protected function compareResults(array $value, array $entity, array $query): void
    {
        Assert::assertEquals($value[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::ID], $entity[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::ID]);
        Assert::assertEquals($query[FeedbackApiDtoInterface::TITLE], $entity[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::TITLE]);
        Assert::assertEquals($query[FeedbackApiDtoInterface::BODY], $entity[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::BODY]);
        Assert::assertEquals($query[FeedbackApiDtoInterface::POSITION], $entity[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::POSITION]);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkFeedback($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkFeedback($entity): void
    {
        Assert::assertArrayHasKey(FeedbackApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(FeedbackApiDtoInterface::TITLE, $entity);
        Assert::assertArrayHasKey(FeedbackApiDtoInterface::BODY, $entity);
        Assert::assertArrayHasKey(FeedbackApiDtoInterface::ACTIVE, $entity);
        Assert::assertArrayHasKey(FeedbackApiDtoInterface::IMAGE, $entity);
        Assert::assertArrayHasKey(FeedbackApiDtoInterface::PREVIEW, $entity);
        Assert::assertArrayHasKey(FeedbackApiDtoInterface::POSITION, $entity);
    }
}
