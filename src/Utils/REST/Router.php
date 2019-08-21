<?php

namespace Informer\Utils\REST;

use Exception;

class Router {

    private $uri;
    private $query;
    private $method;
    private $restTree;

    function __construct() {
        $this->uri = $_SERVER['PATH_INFO'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->query = $_SERVER['QUERY_STRING'];

        $this->restTree = new Endpoint();
    }

    public function add($path, $method, EndpointFunction $function) {
        $subs = explode('/', trim($path, '/'));

        $point = $this->restTree;

        foreach ($subs as $sub) {
            $point = $point->getPath($sub);
        }

        $point->setFunction($method, $function);
    }

    public function route() {
        $subs = explode('/', trim($this->uri, '/'));
        $params = array();

        $point = $this->restTree;

        foreach ($subs as $sub) {
            $point = $point->parsePath($sub, $params);
            if (!$point) {
                break;
            }
        }

        $content = file_get_contents('php://input');

        if ($content) {
            $content = json_decode($content, true);
        }

        if ($point) {
            $auth = null;
            return $point->runMethod($this->method, $params, $content);
        } else {
            throw new Exception("Method not exists", 100);
        }
    }

    public function isCacheable() {
        return strtolower($this->method) == 'get' && $this->query == '';
    }

    public function getRequestPath() {
        return $this->uri;
    }

}
