<?php

namespace Informer\DTO\Client;

use Informer\Entities\MenuItem;
use Informer\Proxy\Client\MenuItemProxy;

class MenuItemDTO {

    public static function modelToProxy(MenuItem $model): MenuItemProxy {
        $catalogId = $model->getCatalog() ? $model->getCatalog()->getId() : null;
        $formId = $model->getForm() ? $model->getForm()->getId() : null;

        $params = $model->getParams();

        if ($catalogId) {
            $params['catalog'] = $catalogId;
        }
        
        if ($formId) {
            $params['form'] = $formId;
        }

        return new MenuItemProxy(
                $model->getId(), MenuItemTypeDTO::modelToProxy($model->getType()), $model->getName(), $model->getIcon(), $params, $model->getOrder()
        );
    }

}
