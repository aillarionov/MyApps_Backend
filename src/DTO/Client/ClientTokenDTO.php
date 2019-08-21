<?php

namespace Informer\DTO\Client;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\ClientToken;
use Informer\Entities\ClientTokenOrg;
use Informer\Entities\Org;
use Informer\Enums\OSType;

class ClientTokenDTO {

    protected static function getEm(): EntityManager {
        global $g_entityManager;
        return $g_entityManager;
    }

    public static function proxyToModel($proxy, ClientToken $existsToken = null): ClientToken {
        if ($existsToken) {
            $clientToken = $existsToken;
        } else if (!empty($proxy['token']) && !empty($proxy['ostype'])) {
            $clientToken = new ClientToken();
            $clientToken->setTokenId($proxy['token']);
            $clientToken->setOsType(new OSType($proxy['ostype']));
        } else {
            throw new Exception("token | ostype", 1001);
        }

        $clientToken->update();

        $actual = array();

        // Add and update
        if (isset($proxy['orgConfigs'])) {
            foreach ($proxy['orgConfigs'] as $orgConfig) {
                $clientTokenOrg = static::findClientTokenOrg($clientToken, intval($orgConfig['orgId']));

                static::parseOrgConfig($clientTokenOrg, $orgConfig);

                array_push($actual, $clientTokenOrg);
            }
        }

        // Remove not actual
        foreach ($clientToken->getClientTokenOrgs() as $clientTokenOrg) {
            if (!in_array($clientTokenOrg, $actual)) {
                $clientToken->getClientTokenOrgs()->removeElement($clientTokenOrg);
                static::getEm()->remove($clientTokenOrg);
            }
        }

        return $clientToken;
    }

    private static function parseOrgConfig(ClientTokenOrg $link, $data) {
        $link->setIsVisitor($data['isVisitor']);
        $link->setIsPresenter($data['isPresenter']);
        $link->setReceiveNotifications($data['receiveNotifications']);
    }

    private static function findClientTokenOrg($clientToken, $orgId) {
        foreach ($clientToken->getClientTokenOrgs() as $clientTokenOrg) {
            if ($clientTokenOrg->getOrg()->getId() == $orgId) {
                return $clientTokenOrg;
            }
        }

        $org = static::getEm()->find(Org::class, $orgId);

        if (!$org) {
            throw new Exception("Org [" . $orgId . "] not found", 1001);
        }

        $clientTokenOrg = new ClientTokenOrg();
        $clientTokenOrg->setClientToken($clientToken);
        $clientTokenOrg->setOrg($org);

        $clientToken->getClientTokenOrgs()->add($clientTokenOrg);

        return $clientTokenOrg;
    }

}
