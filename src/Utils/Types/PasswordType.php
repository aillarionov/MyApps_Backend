<?php

namespace Informer\Utils\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class PasswordType extends Type {

    protected static $name = 'password';

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform) {
        return $platform->getVarcharTypeDeclarationSQL(array(
                    'length' => 255,
                    'fixed' => false
        ));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform) {
        return function($password) use (&$value) {
            return null === $value ? false : static::check($password, $value);
        };
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform) {
        return (null === $value) ? null : static::convert($value);
    }

    public function getName() {
        return static::$name;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform) {
        return true;
    }

    private static function convert($data) {
        return password_hash($data, PASSWORD_BCRYPT);
    }

    private static function check($password, $data) {
        return password_verify($password, $data);
    }

    public static function getType($name) {
        return get_called_class();
    }

    public static function register() {
        Type::addType(static::$name, static::getType(null));
    }

}
