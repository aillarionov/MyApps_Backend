<?php

namespace Informer\DTO\Admin;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\MenuItem;
use Informer\Entities\Org;
use Informer\Proxy\Admin\MenuItemProxy;

class MenuItemDTO {

    public static function modelToProxy(MenuItem $model): MenuItemProxy {
        $catalogId = $model->getCatalog() ? $model->getCatalog()->getId() : null;
        $formId = $model->getForm() ? $model->getForm()->getId() : null;

        return new MenuItemProxy(
                $model->getId(), MenuItemTypeDTO::modelToProxy($model->getType()), $model->getName(), $model->getIcon(), $formId, $catalogId, $model->getParams(), $model->getOrder()
        );
    }

    public static function rawToModel(EntityManager $em, Org $org, array $catalogs, array $forms, array $raw): MenuItem {
        $id = isset($raw['id']) ? intVal($raw['id']) : null;
        if (!$id) {
            throw new Exception("MenuItem id not specified", 2001);
        }

        $menuItem = static::getEntity($em, $org, $id);
        if (!$menuItem) {
            $menuItem = new MenuItem();
            $menuItem->setOrg($org);
        }

        static::fillModelFromRaw($em, $menuItem, $catalogs, $forms, $raw);

        return $menuItem;
    }

    private static function getEntity(EntityManager $em, Org $org, int $id)/* TODO: : ?MenuItem */ {
        return $em->getRepository(MenuItem::class)->findOneBy(array("org" => $org, "id" => $id));
    }

    private static function fillModelFromRaw(EntityManager $em, MenuItem $model, array $catalogs, array $forms, array $raw) {

        if (isset($raw['type'])) {
            $model->setType(MenuItemTypeDTO::rawToModel($raw['type']));
        }

        if (isset($raw['name'])) {
            $model->setName($raw['name']);
        }

        if (isset($raw['icon'])) {
            $model->setIcon($raw['icon']);
        }

        if (isset($raw['form'])) {
            if (!$raw['form']) {
                $form = null;
            } else {
                if (!isset($forms[$raw['form']])) {
                    throw new Exception("Form [" . $raw['form'] . "] not found", 2003);
                }
                $form = $forms[$raw['form']];
            }
            
            $model->setForm($form);
        }

        if (isset($raw['catalog'])) {
            if (!$raw['catalog']) {
                $catalog = null;
            } else {
                if (!isset($catalogs[$raw['catalog']])) {
                    throw new Exception("Catalog [" . $raw['catalog'] . "] not found", 2004);
                }
                $catalog = $catalogs[$raw['catalog']];
            }
            
            $model->setCatalog($catalog);
        }

        if (isset($raw['params'])) {
            $model->setParams($raw['params']);
        }

        if (isset($raw['order'])) {
            $model->setOrder($raw['order']);
        }
    }

}
