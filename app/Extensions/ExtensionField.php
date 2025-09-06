<?php

namespace App\Extensions;

use Illuminate\Support\Facades\Cache;

class ExtensionField
{
    protected static array $fields = [];
    protected static string $cacheKey = 'extension_fields';

    public static function register(string $extension, array $fields): void
    {
        static::$fields[$extension] = $fields;

        // Met à jour le cache
        $cached = Cache::get(static::$cacheKey, []);
        $cached[$extension] = $fields;
        Cache::put(static::$cacheKey, $cached, now()->addHours(1)); // Cache pendant 1h
    }

    public static function getFields(string $extension): array
    {
        // Si les champs sont déjà en mémoire, retourne-les
        if (isset(static::$fields[$extension])) {
            return static::$fields[$extension];
        }

        // Sinon, essaie de les charger depuis le cache
        $cached = Cache::get(static::$cacheKey, []);
        if (isset($cached[$extension])) {
            static::$fields[$extension] = $cached[$extension];
            return $cached[$extension];
        }

        // Aucun champ trouvé
        return [];
    }
}
