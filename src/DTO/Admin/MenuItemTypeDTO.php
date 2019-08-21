<?php

namespace Informer\DTO\Admin;

use Informer\Enums\MenuItemType;

class MenuItemTypeDTO {

    public static function modelToProxy(MenuItemType $model): string {
       return $model->getValue();
    }
    
    public static function rawToModel(string $raw): MenuItemType {
        return new MenuItemType($raw);
    }

}
