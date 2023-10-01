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

namespace Evrinoma\FeedbackBundle\Serializer;

interface GroupInterface
{
    public const API_POST_FEEDBACK = 'API_POST_FEEDBACK';
    public const API_PUT_FEEDBACK = 'API_PUT_FEEDBACK';
    public const API_DELETE_FEEDBACK = 'API_DELETE_FEEDBACK';
    public const API_GET_FEEDBACK = 'API_GET_FEEDBACK';
    public const API_CRITERIA_FEEDBACK = self::API_GET_FEEDBACK;
    public const APP_GET_BASIC_FEEDBACK = 'APP_GET_BASIC_FEEDBACK';
}
