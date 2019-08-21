<?php

namespace Informer\DTO\Admin;

use Informer\Enums\CatalogType;

class CatalogTypeDTO {

    public static function modelToProxy(CatalogType $model): string {
       return $model->getValue();
    }

    public static function rawToModel(string $raw): CatalogType {
        return new CatalogType($raw);
    }
}
