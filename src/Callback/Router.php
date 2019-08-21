<?php

namespace Informer\Callback;

use Exception;
use Informer\Callback\VK\Parser as VKParser;
use Informer\Callback\FB\Parser as FBParser;
use Informer\Enums\Source;

class Router {

    private $uri;

    function __construct() {
        $pathinfo = str_replace("callback", "", $_SERVER['PATH_INFO']);
        $this->uri = trim($pathinfo, "/");
    }

    public function route() {
        $data = file_get_contents('php://input');
        $content = json_decode($data, true);
        
        switch ($this->uri) {
            case Source::FB:
                $callback = new FBParser();
                return $callback->parse($content);

            case Source::VK:
                $callback = new VKParser();
                return $callback->parse($content);

            default:
                throw new Exception("Unknown path [" . $this->uri . "]", 2000);
                break;
        }
    }

}
