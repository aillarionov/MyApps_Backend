<?php

namespace Informer\DTO\Client;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\ClientAd;
use Informer\Entities\ClientAdOrg;
use Informer\Entities\Org;
use Informer\Enums\OSType;

class ClientAdDTO {

    protected static function getEm(): EntityManager {
        global $g_entityManager;
        return $g_entityManager;
    }

    public static function proxyToModel($proxy, ClientAd $existsAd = null): ClientAd {
        if ($existsAd) {
            $clientAd = $existsAd;
        } else if (!empty($proxy['ad']) && !empty($proxy['ostype'])) {
            $clientAd = new ClientAd();
            $clientAd->setAdId($proxy['ad']);
            $clientAd->setOsType(new OSType($proxy['ostype']));
        } else {
            throw new Exception("ad | ostype", 1001);
        }

        $clientAd->update();
        
        $actual = array();

        // Add and update
        foreach ($proxy['orgConfigs'] as $orgConfig) {
            $clientAdOrg = static::findClientAdOrg($clientAd, intval($orgConfig['orgId']));

            static::parseOrgConfig($clientAdOrg, $orgConfig);
            
            array_push($actual, $clientAdOrg);
        }

        // Remove not actual
        foreach ($clientAd->getClientAdOrgs() as $clientAdOrg) {
            if (!in_array($clientAdOrg, $actual)) {
                $clientAd->getClientAdOrgs()->removeElement($clientAdOrg);
                static::getEm()->remove($clientAdOrg);
            }
        }
        
        return $clientAd;
    }

    private static function parseOrgConfig(ClientAdOrg $link, $data) {
        
    }

    private static function findClientAdOrg($clientAd, $orgId) {
        foreach ($clientAd->getClientAdOrgs() as $clientAdOrg) {
            if ($clientAdOrg->getOrg()->getId() == $orgId) {
                return $clientAdOrg;
            }
        }

        $org = static::getEm()->find(Org::class, $orgId);

        if (!$org) {
            throw new Exception("Org [" . $orgId . "] not found", 1001);
        }

        $clientAdOrg = new ClientAdOrg();
        $clientAdOrg->setClientAd($clientAd);
        $clientAdOrg->setOrg($org);

        $clientAd->getClientAdOrgs()->add($clientAdOrg);

        return $clientAdOrg;
    }

}
