<?php

namespace Informer\DTO\Client;

use Informer\Entities\Form;
use Informer\Proxy\Client\FormProxy;

class FormDTO {

    public static function modelToProxy(Form $model): FormProxy {
        $items = array();

        foreach ($model->getItems() as $itemModel) {
            array_push($items, FormItemDTO::modelToProxy($itemModel));
        }

        return new FormProxy(
                $model->getId(), $model->getName(), $items
        );
    }

}
