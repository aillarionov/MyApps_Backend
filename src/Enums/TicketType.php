<?php

namespace Informer\Enums;

use Informer\Utils\Enum\BaseEnum;

class TicketType extends BaseEnum
{
    const SIMPLE = 'simple';
    const URL = 'url';

    public function getName()
    {
        return $this->getValue();
    }
}
