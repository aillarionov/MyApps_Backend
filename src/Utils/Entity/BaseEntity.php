<?php

namespace Informer\Utils\Entity;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

class BaseEntity {

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    public function __construct() {
        
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

    /**
     * Получение идентификатора сущности.
     */
    public function getId() {
        return $this->id;
    }

    public function _setId($id) {
        $this->id = $id;
    }

    public function validate() {
        
    }

    public function delete() {
        global $g_entityremove;
        array_push($g_entityremove, $this);
    }

}
