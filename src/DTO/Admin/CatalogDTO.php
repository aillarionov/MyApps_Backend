<?php

namespace Informer\DTO\Admin;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\DTO\Admin\CatalogTypeDTO;
use Informer\Entities\Catalog;
use Informer\Entities\Org;
use Informer\Proxy\Admin\CatalogProxy;

class CatalogDTO {

    public static function modelToProxy(Catalog $model): CatalogProxy {
        return new CatalogProxy(
                $model->getId(), CatalogTypeDTO::modelToProxy($model->getType()), $model->getVisitorVisible(), $model->getPresenterVisible(), SourceDTO::modelToProxy($model->getSource()), $model->getSourceOwner(), $model->getSourceAlbum(), $model->getVisitorNotificationFilter(), $model->getPresenterNotificationFilter(), $model->getParams()
        );
    }

    public static function rawToModel(EntityManager $em, Org $org, array $raw): Catalog {
        $id = isset($raw['id']) ? intVal($raw['id']) : null;
        if (!$id) {
            throw new Exception("Catalog id not specified", 2001);
        }

        $catalog = static::getEntity($em, $org, $id);
        if (!$catalog) {
            $catalog = new Catalog();
            $catalog->setOrg($org);
        }

        static::fillModelFromRaw($catalog, $raw);

        return $catalog;
    }

    public static function getEntity(EntityManager $em, Org $org, int $id)/* TODO: : ?Catalog */ {
        return $em->getRepository(Catalog::class)->findOneBy(array("org" => $org, "id" => $id));
    }

    private static function fillModelFromRaw(Catalog $model, array $raw) {

        if (isset($raw['type'])) {
            $model->setType(CatalogTypeDTO::rawToModel($raw['type']));
        }

        if (isset($raw['visitorVisible'])) {
            $model->setVisitorVisible($raw['visitorVisible']);
        }

        if (isset($raw['presenterVisible'])) {
            $model->setPresenterVisible($raw['presenterVisible']);
        }

        if (isset($raw['source'])) {
            $model->setSource(SourceDTO::rawToModel($raw['source']));
        }

        if (isset($raw['sourceOwner'])) {
            $model->setSourceOwner($raw['sourceOwner']);
        }

        if (isset($raw['sourceAlbum'])) {
            $model->setSourceAlbum($raw['sourceAlbum']);
        }

        if (isset($raw['visitorNotificationFilter'])) {
            $model->setVisitorNotificationFilter($raw['visitorNotificationFilter']);
        }
        if (isset($raw['presenterNotificationFilter'])) {
            $model->setPresenterNotificationFilter($raw['presenterNotificationFilter']);
        }

        if (isset($raw['params'])) {
            $model->setParams($raw['params']);
        }
    }

}
