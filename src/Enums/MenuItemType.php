<?php

namespace Informer\Enums;

use Informer\Utils\Enum\BaseEnum;

class MenuItemType extends BaseEnum
{
    const STANDART = 'standart';
    const CATALOG = 'catalog';
    const FORM = 'form';

    public function getName()
    {
        return $this->getValue();
    }
}
