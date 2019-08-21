<?php

namespace Informer\REST;

use Informer\DTO\Client\ClientAdDTO;
use Informer\DTO\Client\ClientTokenDTO;
use Informer\DTO\Client\FormDataDTO;
use Informer\DTO\Client\CallbackDataDTO;
use Informer\Entities\ClientAd;
use Informer\Entities\ClientToken;
use Informer\Service\ClientService;
use Informer\Utils\REST\EndpointFunction;
use Informer\Utils\REST\ResultType;
use Informer\Utils\REST\Router;

class ClientREST extends CommonREST {

    public static function register(Router $router) {
        $router->add('/client/data', 'PUT', new EndpointFunction(ResultType::TEXT, false, false, function ($params, $clientDataProxy) {
            static::getEm()->transactional(function($em) use (&$params, &$clientDataProxy) {

                if (!empty($clientDataProxy['token']) && !empty($clientDataProxy['ostype'])) {
                    $clientToken = static::getEm()->getRepository(ClientToken::class)->findOneBy(array("tokenId" => $clientDataProxy['token'], "osType" => $clientDataProxy['ostype']));
                    $clientToken = ClientTokenDTO::proxyToModel($clientDataProxy, $clientToken);
                    ClientService::putClientToken($clientToken);
                }

                if (!empty($clientDataProxy['ad']) && !empty($clientDataProxy['ostype'])) {
                    $clientAd = static::getEm()->getRepository(ClientAd::class)->findOneBy(array("adId" => $clientDataProxy['ad'], "osType" => $clientDataProxy['ostype']));
                    $clientAd = ClientAdDTO::proxyToModel($clientDataProxy, $clientAd);
                    ClientService::putClientAd($clientAd);
                }

                static::getEm()->flush();

                return;
            });
        }));

        $router->add('/client/form', 'POST', new EndpointFunction(ResultType::TEXT, false, false, function ($params, $rawFormData) {
            static::getEm()->transactional(function($em) use (&$params, &$rawFormData) {

                $formData = FormDataDTO::proxyToModel($rawFormData);
                ClientService::postForm($formData);

                static::getEm()->flush();

                return;
            });
        }));

        $router->add('/client/form', 'POST', new EndpointFunction(ResultType::TEXT, false, false, function ($params, $rawFormData) {
            static::getEm()->transactional(function($em) use (&$params, &$rawFormData) {

                $formData = FormDataDTO::proxyToModel($rawFormData);
                ClientService::postForm($formData);

                static::getEm()->flush();

                return;
            });
        }));

        $router->add('/client/callback', 'POST', new EndpointFunction(ResultType::TEXT, false, false, function ($params, $rawCallback) {
            $callbackData = CallbackDataDTO::proxyToModel($rawCallback);
            ClientService::postCallback($callbackData);
        }));
    }

}
