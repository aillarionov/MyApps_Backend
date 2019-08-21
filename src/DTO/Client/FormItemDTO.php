<?php

namespace Informer\DTO\Client;

use Informer\Entities\FormItem;
use Informer\Proxy\Client\FormItemProxy;

class FormItemDTO {

    public static function modelToProxy(FormItem $model): FormItemProxy {
        return new FormItemProxy(
                $model->getId(), FormItemTypeDTO::modelToProxy($model->getType()), $model->getName(), $model->getTitle(), $model->getRequired(), $model->getParams(), $model->getOrder()
        );
    }

}
