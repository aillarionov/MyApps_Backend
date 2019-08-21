<?php

namespace Informer\Utils\DAO;

/**
 * @author alex
 */
class CommonEnumDAO {

    static protected $enumClass = Informer\Utils\Entity\BaseEntity::class;

    public function __construct() {
    }

    public function get($value) {
        return new static::$enumClass($value);
    }

    public function listAll() {
        $class = static::$enumClass;
        return $class::values();
    }

}
