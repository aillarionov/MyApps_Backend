<?php

namespace Informer\REST;

use Informer\Utils\FileUtils;
use Informer\Utils\REST\ResultType;
use Informer\Utils\REST\Router as R;
use const CACHE_DIR;
use const COMPRESSION;

class Router {

    protected static function register(R $router) {
        CatalogREST::register($router);
        OrgREST::register($router);
        ClientREST::register($router);
        AdminREST::register($router);
    }

    private static function process() {
        $router = new R();

        static::register($router);

        $response = $router->route();
        $result = $response[0];
        $endpointFunction = $response[1];

        switch ($endpointFunction->getResultType()) {
            case ResultType::JSON:
                $options = JSON_UNESCAPED_UNICODE;
                if (DEBUG) {
                    $options |= JSON_PRETTY_PRINT;
                }
                $result = json_encode($result, $options);
                break;
        }

        if (COMPRESSION) {
            $result = gzencode($result, COMPRESSION);
            header("Content-Encoding: gzip");
        }


        if ($endpointFunction->getCacheable()) {
            $fileName = $router->getRequestPath();
            if ($fileName != '/') {
                FileUtils::forceFilePutContents(CACHE_DIR . '/' . $fileName, $result);
                header("Last-Modified: " . gmdate(DT_LAST_MODIFIED, filemtime(CACHE_DIR . '/' . $fileName)));
            }
        }

        return $result;
    }

    public static function route() {
        try {
            return static::process();
        } catch (Exception $e) {
            throw new LoggedException($e->getMessage(), $e->getCode());
        }
    }

}
