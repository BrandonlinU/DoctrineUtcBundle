<?php

namespace BrandonlinU\DoctrineUtcBundle\Orm\Type;

use BrandonlinU\DoctrineUtcBundle\Orm\Types;
use BrandonlinU\DoctrineUtcBundle\Util\TimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\DateTimeType;

class UtcDateTimeType extends DateTimeType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if ($value instanceof \DateTime) {
            $value = $value->setTimezone(TimeZone::utc());
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?\DateTime
    {
        $timeZone = date_default_timezone_get();

        date_default_timezone_set('UTC');
        $value = parent::convertToPHPValue($value, $platform);
        date_default_timezone_set($timeZone);

        return $value;
    }

    public function getName(): string
    {
        return Types::UTC_DATETIME;
    }
}
