<?php

namespace Informer\Enums;

use Informer\Utils\Enum\BaseEnum;

class CatalogType extends BaseEnum
{
    const ITEM = 'item';
    const MEMBER = 'member';
    const IMAGE = 'image';
    const NEWS = 'news';
    const GOODS = 'goods';

    public function getName()
    {
        return $this->getValue();
    }
}
