<?php

namespace Informer\REST;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\DTO\Admin\CityDTO;
use Informer\DTO\Admin\OrgDTO;
use Informer\DTO\Admin\OrgSimpleDTO;
use Informer\Entities\Org;
use Informer\Service\AdminService;
use Informer\Service\OrgService;
use Informer\Utils\REST\EndpointFunction;
use Informer\Utils\REST\ResultType;
use Informer\Utils\REST\Router;

class AdminREST extends CommonREST {

    public static function register(Router $router) {
        $router->add('/admin/cities', 'GET', new EndpointFunction(ResultType::JSON, false, false, function ($params) {
            $items = array();
            foreach (OrgService::getCities() as $model) {
                array_push($items, CityDTO::modelToProxy($model));
            }
            return $items;
        }));

        $router->add('/admin/orgs', 'GET', new EndpointFunction(ResultType::JSON, false, true, function ($params, $content, $auth) {
            $user = AdminService::getUser($auth);
            return array_map(function($org) {
                return OrgSimpleDTO::modelToProxy($org);
            }, AdminService::getOrgs($user));
        }));

        $router->add('/admin/org/{orgId}', 'GET', new EndpointFunction(ResultType::JSON, false, true, function ($params, $content, $auth) {
            $user = AdminService::getUser($auth);
            $org = self::getOrg($params);
            AdminService::checkPermission($user, $org);

            return OrgDTO::modelToProxy($org);
        }));

        $router->add('/admin/org', 'POST', new EndpointFunction(ResultType::JSON, false, true, function ($params, $orgRaw, $auth) {
            $data = null;
            static::getEm()->transactional(function($em) use (&$params, &$orgRaw, &$auth, &$data) {

                // Check Permissions
                $user = AdminService::getUser($auth);
                $currentOrg = static::getCurrentOrg($em, $orgRaw);
                AdminService::checkPermission($user, $currentOrg);

                // Save
                $org = OrgDTO::rawToModel($em, $orgRaw);
                AdminService::putOrg($org);

                $em->flush();

                $data = OrgDTO::modelToProxy($org);
            });
            return $data;
        }));

        $router->add('/admin/org', 'PUT', new EndpointFunction(ResultType::JSON, false, true, function ($params, $orgRaw, $auth) {
            $data = null;
            static::getEm()->transactional(function($em) use (&$params, &$orgRaw, &$auth, &$data) {

                $user = AdminService::getUser($auth);

                $orgRaw['id'] = null; // Защита от изменения имеющейся группы
                
                // Save
                $org = OrgDTO::rawToModel($em, $orgRaw);
                
                $org->setUser($user);
                $org->setOrder(1000);
                
                AdminService::putOrg($org);

                $em->flush();

                $data = OrgDTO::modelToProxy($org);
            });
            return $data;
        }));
    }

    private static function getCurrentOrg(EntityManager $em, $raw): Org {
        $id = isset($raw['id']) ? intVal($raw['id']) : null;
        if (!$id) {
            throw new Exception("Org id not specified", 2001);
        }

        $org = $em->find(Org::class, $id);
        if (!$org) {
            throw new Exception("Org [" . $id . "] not found", 2002);
        }

        return $org;
    }

}
