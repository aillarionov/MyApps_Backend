<?php

namespace Informer\REST;

use Informer\DTO\Client\CityDTO;
use Informer\DTO\Client\OrgDTO;
use Informer\DTO\Client\OrgSimpleDTO;
use Informer\Service\CatalogService;
use Informer\Service\OrgService;
use Informer\Utils\REST\EndpointFunction;
use Informer\Utils\REST\ResultType;
use Informer\Utils\REST\Router;

class OrgREST extends CommonREST {

    public static function register(Router $router) {
        $router->add('/cities', 'GET', new EndpointFunction(ResultType::JSON, true, false, function ($params) {
            $items = array();
            foreach (OrgService::getCities() as $model) {
                array_push($items, CityDTO::modelToProxy($model));
            }
            return $items;
        }));
        
        $router->add('/orgs/{cityId}', 'GET', new EndpointFunction(ResultType::JSON, true, false, function ($params) {
            $city = self::getCity($params);
            
            $items = array();

            foreach (OrgService::getOrgs($city) as $model) {
                array_push($items, OrgSimpleDTO::modelToProxy($model));
            }
            return $items;
        }));

        $router->add('/org/{orgId}', 'GET', new EndpointFunction(ResultType::JSON, true, false, function ($params) {
            $org = self::getOrg($params);
            $model = OrgService::getOrg($org);

            return OrgDTO::modelToProxy($model);
        }));
        
        $router->add('/org/code/{code}', 'GET', new EndpointFunction(ResultType::JSON, true, false, function ($params) {
            $model = OrgService::getOrgByCode($params['code']);

            return OrgDTO::modelToProxy($model);
        }));

        $router->add('/cache/orgs', 'GET', new EndpointFunction(ResultType::TEXT, false, false, function ($params) {
            return CatalogService::getCacheFileTime("/orgs");
        }));

        $router->add('/cache/org/{orgId}', 'GET', new EndpointFunction(ResultType::TEXT, false, false, function ($params) {
            return CatalogService::getCacheFileTime("/org/" . $params['orgId']);
        }));
    }

}
