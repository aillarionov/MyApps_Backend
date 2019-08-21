<?php

namespace Informer\Service;

use Exception;
use Informer\Entities\City;
use Informer\Entities\Org;

class OrgService extends CommonService {

    public static function getCities() {
        $items = static::getEm()->getRepository(City::class)->findBy(array(), array("name" => "asc"));

        return $items;
    }
    
    public static function getOrgs(City $city) {
        //$items = static::getEm()->getRepository(Org::class)->findAll();
        $items = static::getEm()->getRepository(Org::class)->findBy(array('suspend' => false, 'city' => $city), array("order" => "asc"));

        return $items;
    }

    public static function getOrg(Org $org) {
        if ($org->getSuspend()) {
            throw new Exception("Org [" . $org->getId() . "] suspend", 2002);
        }

        return $org;
    }

    public static function getOrgByCode(String $code) {
        $org = static::getEm()->getRepository(Org::class)->findOneBy(array('suspend' => false, 'code' => $code));

        if (!$org) {
            throw new Exception("Org by code [" . $code . "] not found", 2002);
        }

        return $org;
    }
    
    public static function clearOrgCache(Org $org) {
        if ($org && $org->getId()) {
            $fileName = CACHE_DIR . '/org/' . $org->getId();
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }
        
        if ($org->getCity()) {
            $fileName = CACHE_DIR . '/orgs/' . $org->getCity()->getId();
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }

        if ($org->getCode()) {
            $fileName = CACHE_DIR . '/org/code/' . $org->getCode();
            if (file_exists($fileName)) {
                unlink($fileName);
            }
        }
    }

}
