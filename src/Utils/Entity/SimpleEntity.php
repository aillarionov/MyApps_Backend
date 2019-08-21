<?php

namespace Informer\Utils\Entity;


class SimpleEntity
{
    public function __construct()
    {
    }
    
//
//    public function getType()
//    {
//        return get_called_class();
//    }
//
//    public function getCleanType()
//    {
//        $name = $this->getType(); //str_replace('DoctrineProxies\\__CG__\\', '', static::getType());
//
//        if (strpos($name, '\\') !== false) {
//            $name = substr($name, strrpos($name, '\\') + 1, strlen($name) - strrpos($name, '\\') - 1);
//        }
//
//        return $name;
//    }

    
    public function delete()
    {
        global $g_entityremove;
        array_push($g_entityremove, $this);
    }
}
