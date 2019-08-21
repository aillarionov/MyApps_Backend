<?php

namespace Informer\Service;

use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;
use Informer\Entities\AuthData;
use Informer\Entities\User;
use const CACHE_DIR;
use const CACHE_LIFE;

class CommonService {

    protected static function getEm(): EntityManager {
        global $g_entityManager;
        return $g_entityManager;
    }

    public static function getCacheFileTime($path) {
        $fileName = CACHE_DIR . '/' . $path;

        if (file_exists($fileName)) {
            if (filemtime($fileName) + CACHE_LIFE > time()) {
                return gmdate(DateTime::ISO8601, filemtime($fileName));
            }
        }

        return null;
    }

    public static function getUser(AuthData $auth): User {
        $user = static::getEm()->getRepository(User::class)->findOneBy(array(
            "login" => $auth->getLogin(),
            "locked" => false
        ));

        if (!$user) {
            throw new Exception("Authentication failed", 80);
        }

        if (!$user->checkPassword($auth->getPassword())) {
            throw new Exception("Authentication failed", 81);
        }

        return $user;
    }

}
