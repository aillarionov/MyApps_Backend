<?php

namespace Informer\DTO\Client;

use Informer\Entities\Org;
use Informer\Proxy\Client\OrgProxy;

class OrgDTO {

    public static function modelToProxy(Org $model): OrgProxy {
        $forms = array();
        $menuItems = array();
        $catalogs = array();

        foreach ($model->getForms() as $formModel) {
            array_push($forms, FormDTO::modelToProxy($formModel));
        }

        foreach ($model->getMenuItems() as $menuItemModel) {
            array_push($menuItems, MenuItemDTO::modelToProxy($menuItemModel));
        }

        foreach ($model->getCatalogs() as $catalogModel) {
            array_push($catalogs, CatalogDTO::modelToProxy($catalogModel));
        }

        $ticket = $model->getTicket() ? TicketDTO::modelToProxy($model->getTicket()) : null;

        $city = CityDTO::modelToProxy($model->getCity());

        return new OrgProxy(
                $model->getId(), $model->getName(), $model->getLogo(), $model->getCode(), $menuItems, $forms, $catalogs, $ticket, $city
        );
    }

}
