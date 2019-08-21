<?php

namespace Informer\DTO\Admin;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\DTO\Admin\FormItemTypeDTO;
use Informer\Entities\Form;
use Informer\Entities\FormItem;
use Informer\Proxy\Admin\FormItemProxy;

class FormItemDTO {

    public static function modelToProxy(FormItem $model): FormItemProxy {
        return new FormItemProxy(
                $model->getId(), FormItemTypeDTO::modelToProxy($model->getType()), $model->getName(), $model->getTitle(), $model->getRequired(), $model->getParams(), $model->getOrder()
        );
    }

    public static function rawToModel(EntityManager $em, Form $form, array $raw): FormItem {
        $id = isset($raw['id']) ? intVal($raw['id']) : null;
        if (!$id) {
            throw new Exception("FormItem id not specified", 2001);
        }

        $formItem = static::getEntity($em, $form, $id);
        if (!$formItem) {
            $formItem = new FormItem();
            $formItem->setForm($form);
        }

        static::fillModelFromRaw($formItem, $raw);

        return $formItem;
    }

    public static function getEntity(EntityManager $em, Form $form, int $id)/* TODO: : ?FormItem */ {
        return $em->getRepository(FormItem::class)->findOneBy(array("form" => $form, "id" => $id));
    }

    private static function fillModelFromRaw(FormItem $model, array $raw) {

        if (isset($raw['type'])) {
            $model->setType(FormItemTypeDTO::rawToModel($raw['type']));
        }

        if (isset($raw['name'])) {
            $model->setName($raw['name']);
        }

        if (isset($raw['title'])) {
            $model->setTitle($raw['title']);
        }

        if (isset($raw['required'])) {
            $model->setRequired($raw['required']);
        }

        if (isset($raw['params'])) {
            $model->setParams($raw['params']);
        }

        if (isset($raw['order'])) {
            $model->setOrder($raw['order']);
        }
    }

}
