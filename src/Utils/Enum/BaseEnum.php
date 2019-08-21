<?php

namespace Informer\Utils\Enum;

abstract class BaseEnum
{
    protected $value;
    protected static $cache = array();

    public function __construct($value)
    {
        if (!$this->isValid($value)) {
            throw new \UnexpectedValueException("Value '$value' is not part of the enum ".get_called_class());
        }

        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getKey()
    {
        return static::search($this->value);
    }

    public function __toString()
    {
        return (string) $this->value;
    }

    final public function equals(Enum $enum)
    {
        return $this->getValue() === $enum->getValue();
    }

    public static function keys()
    {
        return array_keys(static::toArray());
    }

    public static function values()
    {
        $values = array();

        foreach (static::toArray() as $key => $value) {
            $values[$key] = new static($value);
        }

        return $values;
    }

    public static function toArray()
    {
        $class = get_called_class();
        if (!array_key_exists($class, static::$cache)) {
            $reflection = new \ReflectionClass($class);
            static::$cache[$class] = $reflection->getConstants();
        }

        return static::$cache[$class];
    }

    public static function isValid($value)
    {
        return in_array($value, static::toArray(), true);
    }

    public static function isValidKey($key)
    {
        $array = static::toArray();

        return isset($array[$key]);
    }

    public static function search($value)
    {
        return array_search($value, static::toArray(), true);
    }

    public static function __callStatic($name, $arguments)
    {
        $array = static::toArray();
        if (isset($array[$name])) {
            return new static($array[$name]);
        }

        throw new \BadMethodCallException("No static method or enum constant '$name' in class ".get_called_class());
    }

    public static function getType()
    {
        return get_called_class();
    }

    public static function getCleanType()
    {
        $name = static::getType(); //str_replace('DoctrineProxies\\__CG__\\', '', static::getType());

        if (strpos($name, '\\') !== false) {
            $name = substr($name, strrpos($name, '\\') + 1, strlen($name) - strrpos($name, '\\') - 1);
        }

        return $name;
    }
}
