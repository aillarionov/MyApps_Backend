<?php

namespace Informer\Utils\Enum;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class BaseEnumType extends Type
{
    protected static $name;

    protected static $enumType = BaseEnum::class;

    public static function getType($name) {
        return get_called_class();
    }

    public static function register()
    {
        Type::addType(static::$name, static::getType(null));
    }

    public function getName()
    {
        return static::$name;
    }

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL(array(
            'length' => 255,
            'fixed' => false,
        ));
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (is_null($value)) {
            return null;
        }

        $isValid = call_user_func([static::$enumType, 'isValid'], $value);
        if (!$isValid) {
            throw new \Exception(sprintf(
                'The value "%s" is not valid for the enum "%s". Expected one of ["%s"]',
                $value,
                static::$enumType,
                implode('", "', call_user_func([static::$enumType, 'keys']))
            ));
        }

        return new static::$enumType($value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return (string) $value;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

}
