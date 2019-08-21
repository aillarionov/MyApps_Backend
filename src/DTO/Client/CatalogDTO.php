<?php

namespace Informer\DTO\Client;

use Informer\Entities\Catalog;
use Informer\Proxy\Client\CatalogProxy;

class CatalogDTO {

    public static function modelToProxy(Catalog $model): CatalogProxy {
        return new CatalogProxy(
                $model->getId(), CatalogTypeDTO::modelToProxy($model->getType()), $model->getVisitorVisible(), $model->getPresenterVisible()
        );
    }

}
