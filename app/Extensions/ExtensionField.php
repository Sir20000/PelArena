<?php
namespace App\Extensions;

class ExtensionField
{
    protected static array $fields = [];

    public static function register(string $extension, array $fields): void
    {
        static::$fields[$extension] = $fields;
    }

    public static function getFields(string $extension): array
    {
        return static::$fields[$extension] ?? [];
    }
}
