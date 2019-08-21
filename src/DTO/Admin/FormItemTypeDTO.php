<?php

namespace Informer\DTO\Admin;

use Informer\Enums\FormItemType;

class FormItemTypeDTO {

    public static function modelToProxy(FormItemType $model): string {
       return $model->getValue();
    }

    public static function rawToModel(string $raw): FormItemType {
        return new FormItemType($raw);
    }
}
