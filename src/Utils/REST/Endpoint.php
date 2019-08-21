<?php

namespace Informer\Utils\REST;

use Exception;
use Informer\Entities\AuthData;
use function mb_strlen;
use function mb_strpos;
use function mb_substr;

class Endpoint {

    private $childs;
    private $get;
    private $put;
    private $post;
    private $delete;

    function __construct() {
        $this->childs = array();
        $this->get = null;
        $this->put = null;
        $this->post = null;
        $this->delete = null;
    }

    function getPath(string $path) {
        if (!array_key_exists($path, $this->childs)) {
            $this->childs[$path] = new Endpoint();
        }

        return $this->childs[$path];
    }

    function parsePath(string $path, array &$params) {
        // Compare equal
        foreach ($this->childs as $sub => $child) {
            if ($path == $sub) {
                return $child;
            }
        }

        // Compare mask
        foreach ($this->childs as $sub => $child) {
            if (mb_strpos($sub, '{') !== FALSE) {
                $param = mb_substr($sub, 1, mb_strlen($sub) - 2);
                $params[$param] = $path;
                return $child;
            }
        }

        return null;
    }

    function setFunction(string $method, EndpointFunction $function) {
        switch (strtolower($method)) {

            case 'get':
                $this->get = $function;
                break;

            case 'put':
                $this->put = $function;
                break;

            case 'post':
                $this->post = $function;
                break;

            case 'delete':
                $this->delete = $function;
                break;
        }
    }

    function runMethod($method, $params, $content) {
        $function = null;

        switch (strtolower($method)) {

            case 'get':
                $function = $this->get;
                break;

            case 'put':
                $function = $this->put;
                break;

            case 'post':
                $function = $this->post;
                break;

            case 'delete':
                $function = $this->delete;
                break;
        }

        if ($function) {
            $auth = $function->getAuthRequired() ? static::auth() : null;

            $runable = $function->getFunction();

            return array($runable($params, $content, $auth), $function);
        } else {
            throw new Exception("Not implemented", 101);
        }
    }

    private static function auth(): AuthData {
        $login = isset($_SERVER['PHP_AUTH_USER']) ? filter_var($_SERVER['PHP_AUTH_USER'], FILTER_SANITIZE_STRING) : null;
        $password = isset($_SERVER['PHP_AUTH_PW']) ? filter_var($_SERVER['PHP_AUTH_PW'], FILTER_SANITIZE_STRING) : null;

        if (empty($login)) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Authorization required' . $login . $password;
            exit;
        } else {
            return new AuthData($login, $password);
        }
    }

}
