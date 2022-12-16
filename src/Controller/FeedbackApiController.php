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

namespace Evrinoma\FeedbackBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Evrinoma\FeedbackBundle\Dto\FeedbackApiDtoInterface;
use Evrinoma\FeedbackBundle\Exception\FeedbackCannotBeSavedException;
use Evrinoma\FeedbackBundle\Exception\FeedbackInvalidException;
use Evrinoma\FeedbackBundle\Exception\FeedbackNotFoundException;
use Evrinoma\FeedbackBundle\Facade\Feedback\FacadeInterface;
use Evrinoma\FeedbackBundle\Serializer\GroupInterface;
use Evrinoma\DtoBundle\Factory\FactoryDtoInterface;
use Evrinoma\UtilsBundle\Controller\AbstractWrappedApiController;
use Evrinoma\UtilsBundle\Controller\ApiControllerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class FeedbackApiController extends AbstractWrappedApiController implements ApiControllerInterface
{
    private string $dtoClass;

    private ?Request $request;

    private FactoryDtoInterface $factoryDto;

    private FacadeInterface $facade;

    public function __construct(
        SerializerInterface $serializer,
        RequestStack $requestStack,
        FactoryDtoInterface $factoryDto,
        FacadeInterface $facade,
        string $dtoClass
    ) {
        parent::__construct($serializer);
        $this->request = $requestStack->getCurrentRequest();
        $this->factoryDto = $factoryDto;
        $this->dtoClass = $dtoClass;
        $this->facade = $facade;
    }

    /**
     * @Rest\Post("/api/feedback/create", options={"expose": true}, name="api_feedback_create")
     * @OA\Post(
     *     tags={"feedback"},
     *     description="the method perform create feedback",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="class", type="string", default="Evrinoma\FeedbackBundle\Dto\FeedbackApiDto"),
     *                         @OA\Property(property="active", type="string"),
     *                         @OA\Property(property="body", type="string"),
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="position", type="int"),
     *                         @OA\Property(property="image", type="string",  format="binary"),
     *                         @OA\Property(property="preview", type="string",  format="binary")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Create feedback")
     *
     * @return JsonResponse
     */
    public function postAction(): JsonResponse
    {
        /** @var FeedbackApiDtoInterface $feedbackApiDto */
        $feedbackApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusCreated();

        $json = [];
        $error = [];
        $group = GroupInterface::API_POST_FEEDBACK;

        try {
            $this->facade->post($feedbackApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Create feedback', $json, $error);
    }

    /**
     * @Rest\Post("/api/feedback/save", options={"expose": true}, name="api_feedback_save")
     * @OA\Post(
     *     tags={"feedback"},
     *     description="the method perform save feedback for current entity",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 allOf={
     *                     @OA\Schema(
     *                         type="object",
     *                         @OA\Property(property="class", type="string", default="Evrinoma\FeedbackBundle\Dto\FeedbackApiDto"),
     *                         @OA\Property(property="id", type="string"),
     *                         @OA\Property(property="active", type="string"),
     *                         @OA\Property(property="body", type="string"),
     *                         @OA\Property(property="title", type="string"),
     *                         @OA\Property(property="position", type="int"),
     *                         @OA\Property(property="image", type="string",  format="binary"),
     *                         @OA\Property(property="preview", type="string",  format="binary")
     *                     )
     *                 }
     *             )
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Save feedback")
     *
     * @return JsonResponse
     */
    public function putAction(): JsonResponse
    {
        /** @var FeedbackApiDtoInterface $feedbackApiDto */
        $feedbackApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_PUT_FEEDBACK;

        try {
            $this->facade->put($feedbackApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Save feedback', $json, $error);
    }

    /**
     * @Rest\Delete("/api/feedback/delete", options={"expose": true}, name="api_feedback_delete")
     * @OA\Delete(
     *     tags={"feedback"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\FeedbackBundle\Dto\FeedbackApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Delete feedback")
     *
     * @return JsonResponse
     */
    public function deleteAction(): JsonResponse
    {
        /** @var FeedbackApiDtoInterface $feedbackApiDto */
        $feedbackApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $this->setStatusAccepted();

        $json = [];
        $error = [];

        try {
            $this->facade->delete($feedbackApiDto, '', $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->JsonResponse('Delete feedback', $json, $error);
    }

    /**
     * @Rest\Get("/api/feedback/criteria", options={"expose": true}, name="api_feedback_criteria")
     * @OA\Get(
     *     tags={"feedback"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\FeedbackBundle\Dto\FeedbackApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="active",
     *         in="query",
     *         name="active",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="position",
     *         in="query",
     *         name="position",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="title",
     *         in="query",
     *         name="title",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="body",
     *         in="query",
     *         name="body",
     *         @OA\Schema(
     *             type="string",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return feedback")
     *
     * @return JsonResponse
     */
    public function criteriaAction(): JsonResponse
    {
        /** @var FeedbackApiDtoInterface $feedbackApiDto */
        $feedbackApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_CRITERIA_FEEDBACK;

        try {
            $this->facade->criteria($feedbackApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get feedback', $json, $error);
    }

    /**
     * @Rest\Get("/api/feedback", options={"expose": true}, name="api_feedback")
     * @OA\Get(
     *     tags={"feedback"},
     *     @OA\Parameter(
     *         description="class",
     *         in="query",
     *         name="class",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="Evrinoma\FeedbackBundle\Dto\FeedbackApiDto",
     *             readOnly=true
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="id Entity",
     *         in="query",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             default="3",
     *         )
     *     )
     * )
     * @OA\Response(response=200, description="Return feedback")
     *
     * @return JsonResponse
     */
    public function getAction(): JsonResponse
    {
        /** @var FeedbackApiDtoInterface $feedbackApiDto */
        $feedbackApiDto = $this->factoryDto->setRequest($this->request)->createDto($this->dtoClass);

        $json = [];
        $error = [];
        $group = GroupInterface::API_GET_FEEDBACK;

        try {
            $this->facade->get($feedbackApiDto, $group, $json);
        } catch (\Exception $e) {
            $error = $this->setRestStatus($e);
        }

        return $this->setSerializeGroup($group)->JsonResponse('Get feedback', $json, $error);
    }

    /**
     * @param \Exception $e
     *
     * @return array
     */
    public function setRestStatus(\Exception $e): array
    {
        switch (true) {
            case $e instanceof FeedbackCannotBeSavedException:
                $this->setStatusNotImplemented();
                break;
            case $e instanceof UniqueConstraintViolationException:
                $this->setStatusConflict();
                break;
            case $e instanceof FeedbackNotFoundException:
                $this->setStatusNotFound();
                break;
            case $e instanceof FeedbackInvalidException:
                $this->setStatusUnprocessableEntity();
                break;
            default:
                $this->setStatusBadRequest();
        }

        return [$e->getMessage()];
    }
}
