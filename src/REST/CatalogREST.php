<?php

namespace Informer\REST;

use Exception;
use Informer\DTO\Client\CatalogImageDTO;
use Informer\DTO\Client\CatalogItemDTO;
use Informer\DTO\Client\CatalogMemberDTO;
use Informer\DTO\Client\CatalogNewsDTO;
use Informer\Enums\CatalogType;
use Informer\Service\CatalogService;
use Informer\Utils\REST\EndpointFunction;
use Informer\Utils\REST\ResultType;
use Informer\Utils\REST\Router;

class CatalogREST extends CommonREST {

    public static function register(Router $router) {
        $router->add('/catalog/{catalogId}', 'GET', new EndpointFunction(ResultType::JSON, true, false, function ($params) {
            $catalog = self::getCatalog($params);
            $catalogItems = CatalogService::getItems($catalog);
            $proxies = self::itemModelListToProxies($catalog, $catalogItems);
            return $proxies;
        }));

        $router->add('/cache/catalog/{catalogId}', 'GET', new EndpointFunction(ResultType::TEXT, false, false, function ($params) {
            return CatalogService::getCacheFileTime("/catalog/" . $params['catalogId']);
        }));
    }

    protected static function itemModelListToProxies($catalog, $models) {
        $proxies = array();

        switch ($catalog->getType()) {

            case (CatalogType::ITEM):
                foreach ($models as $model) {
                    array_push($proxies, CatalogItemDTO::modelToProxy($model));
                }
                break;

            case (CatalogType::NEWS):
                foreach ($models as $model) {
                    array_push($proxies, CatalogNewsDTO::modelToProxy($model));
                }
                break;

            case (CatalogType::IMAGE):
                foreach ($models as $model) {
                    array_push($proxies, CatalogImageDTO::modelToProxy($model));
                }
                break;

            case (CatalogType::MEMBER):
                foreach ($models as $model) {
                    array_push($proxies, CatalogMemberDTO::modelToProxy($model));
                }
                break;

            default:
                throw new Exception("Unknown item type [" . $catalog->getType() . "] for proxy", 2011);
        }

        return $proxies;
    }

}
