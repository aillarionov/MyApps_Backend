<?php

namespace Informer\DTO\Client;

use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\CallbackData;

class CallbackDataDTO {

    protected static function getEm(): EntityManager {
        global $g_entityManager;
        return $g_entityManager;
    }

    public static function proxyToModel($proxy): CallbackData {

        if (empty($proxy['email'])) {
            throw new Exception("email", 1001);
        }

        $email = $proxy['email'];
        $phone = isset($proxy['phone']) ? $proxy['phone'] : null;
        $subject = isset($proxy['subject']) ? $proxy['subject'] : null;

        return new CallbackData($email, $phone, $subject);
    }

}
