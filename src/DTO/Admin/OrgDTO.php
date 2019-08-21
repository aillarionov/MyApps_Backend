<?php

namespace Informer\DTO\Admin;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\Catalog;
use Informer\Entities\Form;
use Informer\Entities\MenuItem;
use Informer\Entities\Org;
use Informer\Proxy\Admin\OrgProxy;

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
        $city = $model->getCity() ? CityDTO::modelToProxy($model->getCity()) : null;

        return new OrgProxy(
                $model->getId(), $model->getName(), $model->getLogo(), $model->getCode(), $catalogs, $menuItems, $forms, $ticket, $city, $model->getSuspend()
        );
    }

    public static function rawToModel(EntityManager $em, array $raw): Org {
        $id = isset($raw['id']) ? intVal($raw['id']) : null;
        if (!$id) {
            //throw new Exception("Org id not specified", 2001);
            $org = new Org();
        } else {
            $org = static::getEntity($em, $id);
            if (!$org) {
                throw new Exception("Org [" . $id . "] not found", 2002);
            }
        }
        
        static::fillModelFromRaw($org, $raw);

        $catalogs = static::fillCatalogs($em, $org, $raw);
        $forms = static::fillForms($em, $org, $raw);

        static::fillMenuItems($em, $org, $catalogs, $forms, $raw);

        static::fillTicket($em, $org, $raw);

        static::fillCity($em, $org, $raw);

        return $org;
    }

    private static function getEntity(EntityManager $em, int $id): Org {
        return $em->find(Org::class, $id);
    }

    private static function fillModelFromRaw(Org $model, array $raw) {

        if (isset($raw['name'])) {
            $model->setName($raw['name']);
        }

        if (isset($raw['code'])) {
            $model->setCode($raw['code']);
        }

        if (isset($raw['logo'])) {
            $model->setLogo($raw['logo']);
        }

        if (isset($raw['suspend'])) {
            $model->setSuspend($raw['suspend']);
        }
    }

    private static function fillCatalogs(EntityManager $em, Org $org, array $raw): array {
        $result = [];

        if (isset($raw["catalogs"]) && is_array($raw["catalogs"])) {

            $catalogs = $org->getCatalogs();

            // New Items
            $newCatalogs = array();
            foreach ($raw["catalogs"] as $rawCatalog) {
                $catalog = CatalogDTO::rawToModel($em, $org, $rawCatalog);
                array_push($newCatalogs, $catalog);
                $result[$rawCatalog['id']] = $catalog;
            }

            // Remove orphan
            foreach ($catalogs as $catalog) {
                if (!in_array($catalog, $newCatalogs)) {
                    static::deleteItem($em, Catalog::class, $catalog->getId());
                    $em->remove($catalog);
                }
            }

            $em->flush();

            // Add new
            foreach ($newCatalogs as $newCatalog) {
                if (!$catalogs->contains($newCatalog)) {
                    $catalogs->add($newCatalog);
                }
            }
        }

        return $result;
    }

    private static function fillForms(EntityManager $em, Org $org, array $raw): array {
        $result = [];

        if (isset($raw["forms"]) && is_array($raw["forms"])) {

            $forms = $org->getForms();

            // New Items
            $newForms = array();
            foreach ($raw["forms"] as $rawForm) {
                $form = FormDTO::rawToModel($em, $org, $rawForm);
                array_push($newForms, $form);
                $result[$rawForm['id']] = $form;
            }

            // Remove orphan
            foreach ($forms as $form) {
                if (!in_array($form, $newForms)) {
                    static::deleteItem($em, Form::class, $form->getId());
                    $em->remove($form);
                }
            }

            $em->flush();

            // Add new
            foreach ($newForms as $newForm) {
                if (!$forms->contains($newForm)) {
                    $forms->add($newForm);
                }
            }
        }

        return $result;
    }

    private static function fillMenuItems(EntityManager $em, Org $org, array $catalogs, array $forms, array $raw) {
        if (isset($raw["menuItems"]) && is_array($raw["menuItems"])) {

            $menuItems = $org->getMenuItems();

            // New Items
            $newMenuItems = array();
            foreach ($raw["menuItems"] as $rawMenuItem) {
                array_push($newMenuItems, MenuItemDTO::rawToModel($em, $org, $catalogs, $forms, $rawMenuItem));
            }

            // Remove orphan
            foreach ($menuItems as $menuItem) {
                if (!in_array($menuItem, $newMenuItems)) {
                    static::deleteItem($em, MenuItem::class, $menuItem->getId());
                    $em->remove($menuItem);
                }
            }

            $em->flush();

            // Add new
            foreach ($newMenuItems as $newMenuItem) {
                if (!$menuItems->contains($newMenuItem)) {
                    $menuItems->add($newMenuItem);
                }
            }
        }
    }

    private static function deleteItem(EntityManager $em, $class, $id) {
        $qb = $em->createQueryBuilder();
        $qb->delete($class, 'm');
        $qb->where('m.id = :id');
        $qb->setParameter('id', $id);
        $qb->getQuery()->execute();
    }

    private static function fillTicket(EntityManager $em, Org $org, array $raw) {
        if (isset($raw["ticket"])) {
            $org->setTicket(TicketDTO::rawToModel($em, $org, $raw["ticket"]));
        }
    }

    private static function fillCity(EntityManager $em, Org $org, array $raw) {
        if (isset($raw["city"])) {
            $org->setCity(CityDTO::rawToModel($em, $raw["city"]));
        }
    }

}
