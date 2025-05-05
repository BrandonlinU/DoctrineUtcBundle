<?php

namespace BrandonlinU\DoctrineUtcBundle\Orm\Type;

use BrandonlinU\DoctrineUtcBundle\Orm\Types;
use BrandonlinU\DoctrineUtcBundle\Util\TimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeImmutableType;

class UtcDateTimeImmutableType extends DateTimeImmutableType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof \DateTimeImmutable) {
            $value = $value->setTimezone(TimeZone::utc());
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?\DateTimeImmutable
    {
        $timeZone = date_default_timezone_get();

        date_default_timezone_set('UTC');
        $value = parent::convertToPHPValue($value, $platform);
        date_default_timezone_set($timeZone);

        return $value;
    }

    public function getName(): string
    {
        return Types::UTC_DATETIME_IMMUTABLE;
    }
}
