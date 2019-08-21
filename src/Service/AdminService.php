<?php

namespace Informer\Service;

use Exception;
use Informer\Entities\Org;
use Informer\Entities\User;

class AdminService extends CommonService {

    public static function getOrgs(User $user) {
        $filter = $user->getIsAdmin() ? array() : array("user" => $user);
        $items = static::getEm()->getRepository(Org::class)->findBy($filter, array("order" => "asc"));
        return $items;
    }

    public static function checkPermission(User $user, Org $org) {
        if (!$user->getIsAdmin() && $org->getUser() != $user) {
            throw new Exception("Permission denied", 82);
        }
    }

    public static function putOrg(Org $org) {
        static::getEm()->persist($org);
        OrgService::clearOrgCache($org);
        foreach ($org->getCatalogs() as $catalog) {
            CatalogService::clearCatalogCache($catalog);
        }
    }

}
