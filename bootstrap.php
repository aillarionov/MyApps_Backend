<?php

date_default_timezone_set('Europe/Moscow');

require_once "paths.php";
require_once "config.php";
require_once "vendor/autoload.php";

// Ислючение с логированием и отправкой письма
require_once UTILS_DIR . '/Exception/LoggedException.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Informer\Utils\Logger;

$paths = array(
    __DIR__ . "/src/Entities",
    __DIR__ . "/src/Utils/Entity"
);

// Types registration
Informer\Utils\Types\PasswordType::register();

// Enums registration
Informer\Enums\OSTypeEnumType::register();
Informer\Enums\CatalogTypeEnumType::register();
Informer\Enums\SourceEnumType::register();
Informer\Enums\MenuItemTypeEnumType::register();
Informer\Enums\FormItemTypeEnumType::register();
Informer\Enums\TicketTypeEnumType::register();


$config = Setup::createAnnotationMetadataConfiguration($paths, DEBUG, 'proxy', new Doctrine\Common\Cache\ArrayCache());

// $config = Setup::createAnnotationMetadataConfiguration($paths, DEBUG);
// $config->setAutoGenerateProxyClasses(DEBUG); // Иначе под нагрузкой начинают валиться ошибки
// $config->setProxyDir('proxy');


if (DEBUG) {
    // Логгер
    $logdir = SQL_LOGS_DIR;
    if (!is_dir($logdir)) {
        mkdir($logdir, DIR_PERMISSION, true);
    }

    $logger = new Logger($logdir . '/doctrine.log');
    $config->setSQLLogger($logger);
}


$dbparams = array(
    'host' => DBHOST,
    'driver' => DBDRIVER,
    'user' => DBUSER,
    'password' => DBPASS,
    'dbname' => DBNAME
);

$g_entityManager = EntityManager::create($dbparams, $config);


$g_auth = null;

$g_logs = array();
$g_entityremove = array();
