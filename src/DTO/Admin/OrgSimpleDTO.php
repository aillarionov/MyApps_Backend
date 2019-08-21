<?php

namespace Informer\DTO\Admin;


use Informer\Entities\Org;
use Informer\Proxy\Admin\OrgSimpleProxy;

class OrgSimpleDTO {

    public static function modelToProxy(Org $model): OrgSimpleProxy {
        return new OrgSimpleProxy(
                $model->getId(), $model->getName(), $model->getLogo(), $model->getCode()
        );
    }

}
