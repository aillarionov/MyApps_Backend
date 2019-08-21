<?php

namespace Informer\DTO\Client;

use Informer\Entities\City;
use Informer\Proxy\Client\CityProxy;

class CityDTO {

    public static function modelToProxy(City $model): CityProxy {
        return new CityProxy($model->getId(), $model->getName());
    }

}
