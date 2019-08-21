<?php

namespace Informer\Callback\FB;

use Informer\Callback\Common\CommonCallback;

class Confirmation extends CommonCallback {

    public function __construct() {
    }

    public function execute($params, $data) {
        $hub_challenge = isset($params['hub_challenge']) ? $params['hub_challenge'] : null;
        $hub_verify_token = isset($params['hub_verify_token']) ? $params['hub_verify_token'] : null;
        
        if ($hub_verify_token == FB_CALLBACK_TOKEN) {
            return $hub_challenge;
        }
    }

}
