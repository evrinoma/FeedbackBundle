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

namespace Evrinoma\FeedbackBundle\Entity\Feedback;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\FeedbackBundle\Model\Feedback\AbstractFeedback;

/**
 * @ORM\Table(name="e_feedback")
 * @ORM\Entity
 */
class BaseFeedback extends AbstractFeedback
{
}
