<?php

namespace Informer\DTO\Admin;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\DTO\Admin\FormItemDTO;
use Informer\Entities\Form;
use Informer\Entities\Org;
use Informer\Proxy\Admin\FormProxy;

class FormDTO {

    public static function modelToProxy(Form $model): FormProxy {
        $items = array();

        foreach ($model->getItems() as $itemModel) {
            array_push($items, FormItemDTO::modelToProxy($itemModel));
        }

        return new FormProxy(
                $model->getId(), $model->getName(), $model->getDataEmail(), $items
        );
    }

    public static function getEntity(EntityManager $em, Org $org, int $id)/* TODO: : ?Form */ {
        return $em->getRepository(Form::class)->findOneBy(array("org" => $org, "id" => $id));
    }

    public static function rawToModel(EntityManager $em, Org $org, array $raw): Form {
        $id = isset($raw['id']) ? intVal($raw['id']) : null;
        if (!$id) {
            throw new Exception("Form id not specified", 2001);
        }

        $form = static::getEntity($em, $org, $id);
        if (!$form) {
            $form = new Form();
            $form->setOrg($org);
        }

        static::fillModelFromRaw($em, $form, $raw);

        static::fillItems($em, $form, $raw);

        return $form;
    }

    private static function fillModelFromRaw(EntityManager $em, Form $model, array $raw) {
        if (isset($raw['name'])) {
            $model->setName($raw['name']);
        }

        if (isset($raw['dataEmail'])) {
            $model->setDataEmail($raw['dataEmail']);
        }
    }

    private static function fillItems(EntityManager $em, Form $model, array $raw) {
        if (isset($raw["items"]) && is_array($raw["items"])) {

            $items = $model->getItems();

            // New Items
            $newItems = array();
            foreach ($raw["items"] as $rawItem) {
                array_push($newItems, FormItemDTO::rawToModel($em, $model, $rawItem));
            }

            // Remove orphan
            foreach ($items as $item) {
                if (!in_array($item, $newItems)) {
                    $em->remove($item);
                }
            }

            $em->flush();

            // Add new
            foreach ($newItems as $newItem) {
                if (!$items->contains($newItem)) {
                    $items->add($newItem);
                }
            }
        }
    }

}
