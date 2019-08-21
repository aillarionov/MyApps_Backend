<?php

namespace Informer\Enums;

use Informer\Utils\Enum\BaseEnum;

class Source extends BaseEnum
{
    const VK = 'vk';
    const FB = 'fb';

    public function getName()
    {
        return $this->getValue();
    }
}
