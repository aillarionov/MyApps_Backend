<?php

namespace Informer\Enums;

use Informer\Utils\Enum\BaseEnum;

class FormItemType extends BaseEnum
{
    const STRING = 'string';
    const PHONE = 'phone';
    const EMAIL = 'email';
    const TEXT = 'text';

    public function getName()
    {
        return $this->getValue();
    }
}
