<?php

namespace BrandonlinU\DoctrineUtcBundle\Util;

/**
 * @internal
 */
final class TimeZone
{
    /**
     * @var array<string, \DateTimeZone>
     */
    private static array $timezones = [];

    // Static class
    private function __construct() {
    }

    public static function utc(): \DateTimeZone
    {
        return self::get('UTC');
    }

    /**
     * @throws \DateInvalidTimeZoneException
     */
    public static function get(string $timezone): \DateTimeZone
    {
        return self::$timezones[$timezone] ??= new \DateTimeZone($timezone);
    }
}
