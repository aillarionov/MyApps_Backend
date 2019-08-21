<?php

require_once "bootstrap.php";

use Doctrine\DBAL\DBALException;
use Informer\REST\Router;

try {
    echo Router::route();
} catch (DBALException $e) {
    header("HTTP/1.0 500 Internal Server Error");
    
    if (DEBUG) {
        echo $e->getMessage(). " (".$e->getCode().")";
    } else {
        echo "Internal exception (10)";
    }
    
    die();

} catch (Exception $e) {
    header("HTTP/1.0 500 Internal Server Error");
    echo $e->getMessage(). " (".$e->getCode().")";
    die();
}