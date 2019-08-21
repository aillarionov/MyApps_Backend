<?php

namespace Informer\DTO\Admin;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\City;
use Informer\Proxy\Admin\CityProxy;

class CityDTO {

    public static function modelToProxy(City $model): CityProxy {
        return new CityProxy($model->getId(), $model->getName());
    }

    public static function rawToModel(EntityManager $em, array $raw): City {
        $id = isset($raw['id']) ? intVal($raw['id']) : null;
        if (!$id) {
            throw new Exception("City id not specified", 2001);
        }

        $city = static::getEntity($em, $id);
        if (!$city) {
            throw new Exception("City [" . $id . "] not found", 2002);
        }

        return $city;
    }

    public static function getEntity(EntityManager $em, int $id)/* TODO: : ?City */ {
        return $em->find(City::class, $id);
    }
}
