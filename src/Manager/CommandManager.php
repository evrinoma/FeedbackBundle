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

namespace Evrinoma\FeedbackBundle\Manager;

use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeCreatedException;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeRemovedException;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeSavedException;
use Evrinoma\FeedbackBundle\Exception\FeedbackInvalidException;
use Evrinoma\FeedbackBundle\Exception\FeedbackNotFoundException;
use Evrinoma\FeedbackBundle\Factory\Feedback\FactoryInterface;
use Evrinoma\FeedbackBundle\Mediator\CommandMediatorInterface;
use Evrinoma\FeedbackBundle\Model\Feedback\FeedbackInterface;
use Evrinoma\FeedbackBundle\Repository\Feedback\FeedbackRepositoryInterface;
use Evrinoma\UtilsBundle\Validator\ValidatorInterface;

final class CommandManager implements CommandManagerInterface
{
    private FeedbackRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private FactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    /**
     * @param ValidatorInterface          $validator
     * @param FeedbackRepositoryInterface $repository
     * @param FactoryInterface            $factory
     * @param CommandMediatorInterface    $mediator
     */
    public function __construct(ValidatorInterface $validator, FeedbackRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackInvalidException
     * @throws FeedbackCannotBeCreatedException
     * @throws FeedbackCannotBeSavedException
     */
    public function post(FeedbackApiDtoInterface $dto): FeedbackInterface
    {
        $feedback = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $feedback);

        $errors = $this->validator->validate($feedback);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new FeedbackInvalidException($errorsString);
        }

        $this->repository->save($feedback);

        return $feedback;
    }

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @return FeedbackInterface
     *
     * @throws FeedbackInvalidException
     * @throws FeedbackNotFoundException
     * @throws FeedbackCannotBeSavedException
     */
    public function put(FeedbackApiDtoInterface $dto): FeedbackInterface
    {
        try {
            $feedback = $this->repository->find($dto->idToString());
        } catch (FeedbackNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $feedback);

        $errors = $this->validator->validate($feedback);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new FeedbackInvalidException($errorsString);
        }

        $this->repository->save($feedback);

        return $feedback;
    }

    /**
     * @param FeedbackApiDtoInterface $dto
     *
     * @throws FeedbackCannotBeRemovedException
     * @throws FeedbackNotFoundException
     */
    public function delete(FeedbackApiDtoInterface $dto): void
    {
        try {
            $feedback = $this->repository->find($dto->idToString());
        } catch (FeedbackNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $feedback);
        try {
            $this->repository->remove($feedback);
        } catch (FeedbackCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
