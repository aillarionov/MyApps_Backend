<?php

require_once "bootstrap.php";

use Informer\Callback\Router;

$router = new Router();

echo $router->route();
