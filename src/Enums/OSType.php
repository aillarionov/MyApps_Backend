<?php

namespace Informer\Enums;

use Informer\Utils\Enum\BaseEnum;

class OSType extends BaseEnum
{
    const IOS = 'ios';
    const ANDROID = 'android';

    public function getName()
    {
        return $this->getValue();
    }
}
