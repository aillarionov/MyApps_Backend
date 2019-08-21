<?php

namespace Informer\DTO\Client;


use Informer\Entities\Org;
use Informer\Proxy\Client\OrgSimpleProxy;

class OrgSimpleDTO {

    public static function modelToProxy(Org $model): OrgSimpleProxy {
        $city = CityDTO::modelToProxy($model->getCity());
        
        return new OrgSimpleProxy(
                $model->getId(), $model->getName(), $model->getLogo(), $model->getCode(), $city
        );
    }

}
