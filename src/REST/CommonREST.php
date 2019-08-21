<?php

namespace Informer\REST;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\Catalog;
use Informer\Entities\City;
use Informer\Entities\Org;

abstract class CommonREST {

    protected static function getEm(): EntityManager {
        global $g_entityManager;
        return $g_entityManager;
    }

    protected static function getCity($params): City {
        $cityId = isset($params['cityId']) ? intval($params['cityId']) : null;

        if (!$cityId) {
            throw new Exception("cityId", 1001);
        }

        $city = self::getEm()->find(City::class, $cityId);

        if (!$city) {
            throw new Exception("City [" . $cityId . "] not found", 2001);
        }

        return $city;
    }

    protected static function getOrg($params): Org {
        $orgId = isset($params['orgId']) ? intval($params['orgId']) : null;

        if (!$orgId) {
            throw new Exception("orgId", 1001);
        }

        $org = self::getEm()->find(Org::class, $orgId);

        if (!$org) {
            throw new Exception("Org [" . $orgId . "] not found", 2001);
        }

        return $org;
    }

    protected static function getCatalog($params): Catalog {
        $catalogId = isset($params['catalogId']) ? intval($params['catalogId']) : null;

        if (!$catalogId) {
            throw new Exception("catalogId", 1001);
        }

        $catalog = self::getEm()->find(Catalog::class, $catalogId);

        if (!$catalog) {
            throw new Exception("Catalog [" . $catalogId . "] not found", 2001);
        }

        return $catalog;
    }

}
