<?php

namespace Informer\Callback\Common;

use Doctrine\ORM\EntityManager;

class CommonCallback  {
    
    protected static function getEm(): EntityManager {
        global $g_entityManager;
        return $g_entityManager;
    }
    

}
