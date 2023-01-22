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

namespace Evrinoma\FeedbackBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Entity\Feedback\BaseFeedback;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;

class FeedbackFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        [
            FeedbackApiDtoInterface::TITLE => 'ite',
            FeedbackApiDtoInterface::BODY => 'http://ite',
            FeedbackApiDtoInterface::POSITION => 1,
            FeedbackApiDtoInterface::ACTIVE => 'a',
            'created_at' => '2008-10-23 10:21:50',
            FeedbackApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FeedbackApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        [
            FeedbackApiDtoInterface::TITLE => 'kzkt',
            FeedbackApiDtoInterface::BODY => 'http://kzkt',
            FeedbackApiDtoInterface::POSITION => 2,
            FeedbackApiDtoInterface::ACTIVE => 'a',
            'created_at' => '2015-10-23 10:21:50',
            FeedbackApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FeedbackApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        [
            FeedbackApiDtoInterface::TITLE => 'c2m',
            FeedbackApiDtoInterface::BODY => 'http://c2m',
            FeedbackApiDtoInterface::POSITION => 3,
            FeedbackApiDtoInterface::ACTIVE => 'a',
            'created_at' => '2020-10-23 10:21:50',
            FeedbackApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FeedbackApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        [
            FeedbackApiDtoInterface::TITLE => 'kzkt2',
            FeedbackApiDtoInterface::BODY => 'http://kzkt2',
            FeedbackApiDtoInterface::POSITION => 1,
            FeedbackApiDtoInterface::ACTIVE => 'd',
            'created_at' => '2015-10-23 10:21:50',
            FeedbackApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FeedbackApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
            ],
        [
            FeedbackApiDtoInterface::TITLE => 'nvr',
            FeedbackApiDtoInterface::BODY => 'http://nvr',
            FeedbackApiDtoInterface::POSITION => 2,
            FeedbackApiDtoInterface::ACTIVE => 'b',
            'created_at' => '2010-10-23 10:21:50',
            FeedbackApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FeedbackApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
        [
            FeedbackApiDtoInterface::TITLE => 'nvr2',
            FeedbackApiDtoInterface::BODY => 'http://nvr2',
            FeedbackApiDtoInterface::POSITION => 3,
            FeedbackApiDtoInterface::ACTIVE => 'd',
            'created_at' => '2010-10-23 10:21:50',
            FeedbackApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FeedbackApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
            ],
        [
            FeedbackApiDtoInterface::TITLE => 'nvr3',
            FeedbackApiDtoInterface::BODY => 'http://nvr3',
            FeedbackApiDtoInterface::POSITION => 1,
            FeedbackApiDtoInterface::ACTIVE => 'd',
            'created_at' => '2011-10-23 10:21:50',
            FeedbackApiDtoInterface::IMAGE => 'PATH://TO_IMAGE',
            FeedbackApiDtoInterface::PREVIEW => 'PATH://TO_IMAGE_PREV',
        ],
    ];

    protected static string $class = BaseFeedback::class;

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $short = self::getReferenceName();
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setImage($record[FeedbackApiDtoInterface::IMAGE])
                ->setPreview($record[FeedbackApiDtoInterface::PREVIEW])
                ->setActive($record[FeedbackApiDtoInterface::ACTIVE])
                ->setTitle($record[FeedbackApiDtoInterface::TITLE])
                ->setBody($record[FeedbackApiDtoInterface::BODY])
                ->setPosition($record[FeedbackApiDtoInterface::POSITION])
                ->setCreatedAt(new \DateTimeImmutable($record['created_at']))
            ;

            $this->expandEntity($entity, $record);

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::FEEDBACK_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}
