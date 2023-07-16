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

namespace Evrinoma\FeedbackBundle\Serializer\Symfony;

use Evrinoma\UtilsBundle\Serialize\ConfigurationInterface;
use Symfony\Component\Serializer\Mapping\Loader\LoaderInterface;
use Symfony\Component\Serializer\Mapping\Loader\YamlFileLoader;

class ConfigurationFeedback implements ConfigurationInterface
{
    private string $fileName = '/src/Serializer/Symfony/yml/FeedbackBundle/Model.Feedback.AbstractFeedback.yml';

    private string $projectDir = '';

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getFile(): LoaderInterface
    {
        return new YamlFileLoader($this->projectDir.$this->fileName);
    }
}
