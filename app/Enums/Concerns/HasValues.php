<?php

namespace App\Enums\Concerns;

trait HasValues
{
    /**
     * Return all backing values of the enum.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Build a quoted, comma-separated list of all enum values,
     * ready to drop into a SQL "IN (...)" / CHECK clause.
     */
    public static function sqlList(): string
    {
        return "'".implode("', '", self::values())."'";
    }
}
