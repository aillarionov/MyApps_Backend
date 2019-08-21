<?php

use Informer\Service\NotificationService;

require_once "bootstrap.php";

try {
    echo NotificationService::sendNotifications();
} catch (Exception $e) {
    throw new LoggedException($e->getMessage(), $e->getCode());
}
