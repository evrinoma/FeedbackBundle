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

namespace Evrinoma\FeedbackBundle\Tests\Functional\Action;

use Evrinoma\FeedbackBundle\Dto\FeedbackApiDto;
use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Tests\Functional\Helper\BaseFeedbackTestTrait;
use Evrinoma\FeedbackBundle\Tests\Functional\ValueObject\Feedback\Active;
use Evrinoma\FeedbackBundle\Tests\Functional\ValueObject\Feedback\Body;
use Evrinoma\FeedbackBundle\Tests\Functional\ValueObject\Feedback\Id;
use Evrinoma\FeedbackBundle\Tests\Functional\ValueObject\Feedback\Image;
use Evrinoma\FeedbackBundle\Tests\Functional\ValueObject\Feedback\Position;
use Evrinoma\FeedbackBundle\Tests\Functional\ValueObject\Feedback\Preview;
use Evrinoma\FeedbackBundle\Tests\Functional\ValueObject\Feedback\Title;
use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use PHPUnit\Framework\Assert;

class BaseFeedback extends AbstractServiceTest implements BaseFeedbackTestInterface
{
    use BaseFeedbackTestTrait;

    public const API_GET = 'evrinoma/api/feedback';
    public const API_CRITERIA = 'evrinoma/api/feedback/criteria';
    public const API_DELETE = 'evrinoma/api/feedback/delete';
    public const API_PUT = 'evrinoma/api/feedback/save';
    public const API_POST = 'evrinoma/api/feedback/create';

    protected string $methodPut = ApiBrowserTestInterface::POST;

    protected static array $header = ['CONTENT_TYPE' => 'multipart/form-data'];
    protected bool $form = true;

    protected static function getDtoClass(): string
    {
        return FeedbackApiDto::class;
    }

    protected static function defaultData(): array
    {
        static::initFiles();

        return [
            FeedbackApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            FeedbackApiDtoInterface::ID => Id::default(),
            FeedbackApiDtoInterface::TITLE => Title::default(),
            FeedbackApiDtoInterface::POSITION => Position::value(),
            FeedbackApiDtoInterface::ACTIVE => Active::value(),
            FeedbackApiDtoInterface::BODY => Body::default(),
            FeedbackApiDtoInterface::IMAGE => Image::default(),
            FeedbackApiDtoInterface::PREVIEW => Preview::default(),
        ];
    }

    public function actionPost(): void
    {
        $this->createFeedback();
        $this->testResponseStatusCreated();

        static::$files = [];

        $this->createFeedback();
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria([FeedbackApiDtoInterface::DTO_CLASS => static::getDtoClass(), FeedbackApiDtoInterface::ACTIVE => Active::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);

        $find = $this->criteria([FeedbackApiDtoInterface::DTO_CLASS => static::getDtoClass(), FeedbackApiDtoInterface::ID => Id::value(), FeedbackApiDtoInterface::ACTIVE => Active::block(), FeedbackApiDtoInterface::TITLE => Title::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria([FeedbackApiDtoInterface::DTO_CLASS => static::getDtoClass(), FeedbackApiDtoInterface::ACTIVE => Active::value(), FeedbackApiDtoInterface::ID => Id::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([FeedbackApiDtoInterface::DTO_CLASS => static::getDtoClass(), FeedbackApiDtoInterface::ACTIVE => Active::delete()]);
        $this->testResponseStatusOK();
        Assert::assertCount(3, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([FeedbackApiDtoInterface::DTO_CLASS => static::getDtoClass(), FeedbackApiDtoInterface::ACTIVE => Active::delete(), FeedbackApiDtoInterface::TITLE => Title::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find[PayloadModel::PAYLOAD]);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::ACTIVE, $find[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::ACTIVE]);

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::DELETED, $delete[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::ACTIVE]);
    }

    public function actionPut(): void
    {
        $query = static::getDefault([FeedbackApiDtoInterface::ID => Id::value(), FeedbackApiDtoInterface::TITLE => Title::value(), FeedbackApiDtoInterface::BODY => Body::value(), FeedbackApiDtoInterface::POSITION => Position::value()]);

        $find = $this->assertGet(Id::value());

        $updated = $this->put($query);
        $this->testResponseStatusOK();

        $this->compareResults($find, $updated, $query);

        static::$files = [];

        $updated = $this->put($query);
        $this->testResponseStatusOK();

        $this->compareResults($find, $updated, $query);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete(Id::empty());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault([
            FeedbackApiDtoInterface::ID => Id::wrong(),
            FeedbackApiDtoInterface::TITLE => Title::wrong(),
            FeedbackApiDtoInterface::BODY => Body::wrong(),
            FeedbackApiDtoInterface::POSITION => Position::wrong(),
        ]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $created = $this->createFeedback();
        $this->testResponseStatusCreated();
        $this->checkResult($created);

        $query = static::getDefault([FeedbackApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::ID], FeedbackApiDtoInterface::TITLE => Title::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([FeedbackApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::ID], FeedbackApiDtoInterface::BODY => Body::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([FeedbackApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::ID], FeedbackApiDtoInterface::POSITION => Position::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([FeedbackApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::ID], FeedbackApiDtoInterface::IMAGE => Image::empty(), FeedbackApiDtoInterface::PREVIEW => Preview::empty()]);
        static::$files[static::getDtoClass()] = [];

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([FeedbackApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][FeedbackApiDtoInterface::ID], FeedbackApiDtoInterface::IMAGE => Image::empty(), FeedbackApiDtoInterface::PREVIEW => Preview::empty()]);
        static::$files = [];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createFeedback();
        $this->testResponseStatusCreated();
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankName();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankUrl();
        $this->testResponseStatusUnprocessable();
    }
}
