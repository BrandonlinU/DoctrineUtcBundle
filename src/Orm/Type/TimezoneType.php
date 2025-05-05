<?php

namespace BrandonlinU\DoctrineUtcBundle\Orm\Type;

use BrandonlinU\DoctrineUtcBundle\Orm\Types;
use BrandonlinU\DoctrineUtcBundle\Util\TimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Exception\InvalidFormat;
use Doctrine\DBAL\Types\Exception\InvalidType;
use Doctrine\DBAL\Types\Type;

class TimezoneType extends Type
{
    public function getSqlDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL(['length' => 180]);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value === null) {
            return null;
        }

        if ($value instanceof \DateTimeZone) {
            return $value->getName();
        }

        throw InvalidType::new(
            $value,
            self::getTypeRegistry()->lookupName($this),
            ['null', \DateTimeZone::class],
        );
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): \DateTimeZone
    {
        if ($value === null || $value instanceof \DateTimeZone) {
            return $value;
        }

        try {
            $timeZone = TimeZone::get($value);
        } catch (\DateInvalidTimeZoneException $e) {
            throw InvalidFormat::new(
                $value,
                self::getTypeRegistry()->lookupName($this),
                'One of the supported timezones (https://www.php.net/manual/en/timezones.php)',
                $e,
            );
        }

        return $timeZone;
    }

    public function getName(): string
    {
        return Types::TIMEZONE;
    }
}
