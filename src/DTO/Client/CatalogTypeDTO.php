<?php

namespace Informer\DTO\Client;

use Informer\Enums\CatalogType;

class CatalogTypeDTO {

    public static function modelToProxy(CatalogType $model): string {
       return $model->getValue();
    }

}
