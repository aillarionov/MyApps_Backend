<?php

namespace Informer\DTO\Client;

use Informer\Enums\MenuItemType;

class MenuItemTypeDTO {

    public static function modelToProxy(MenuItemType $model): string {
       return $model->getValue();
    }

}
