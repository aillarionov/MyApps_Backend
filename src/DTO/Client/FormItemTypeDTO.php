<?php

namespace Informer\DTO\Client;

use Informer\Enums\FormItemType;

class FormItemTypeDTO {

    public static function modelToProxy(FormItemType $model): string {
       return $model->getValue();
    }

}
