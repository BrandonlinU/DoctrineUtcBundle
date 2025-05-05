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
        if ($value instanceof \DateTimeInterface) {
            $value = $value->setTimezone(TimeZone::utc());
        }

        return parent::convertToDatabaseValue($value, $platform);
    }

    public function getName(): string
    {
        return Types::UTC_DATETIME;
    }
}
