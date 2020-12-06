<?php


namespace YusufOnur\LaravelLocalization\Support\CacheManagement;


use Illuminate\Support\Facades\Cache;
use YusufOnur\LaravelLocalization\Models\Language;
use YusufOnur\LaravelLocalization\DataTransferObjects\LanguageData;

class CacheManagement
{
    public static function getCacheValue(string $name)
    {
        if (!(bool)config("laravel-localization.cache.status", true)) {
            return null;
        }

        $cacheName = self::setCacheName($name);

        return Cache::get($cacheName);
    }

    public static function getOrCreateCacheValue(string $name, $callback)
    {
        $tags = self::setCacheTags($name);
        $cacheName = self::setCacheName($name);
        $ttl = config("laravel-localization.cache.ttl");
        $status = (bool)config("laravel-localization.cache.status");

        if (!$status) {
            return $callback();
        }

        if (Cache::getStore() instanceof \Illuminate\Cache\TaggableStore) {
            return Cache::tags($tags)->remember($cacheName, $ttl, $callback);
        }

        return Cache::remember($cacheName, $ttl, $callback);
    }

    public static function flushCache(string|null $tag): bool
    {
        if (Cache::getStore() instanceof \Illuminate\Cache\TaggableStore) {
            return Cache::tags(config("laravel-localization.cache.tag"))->flush();
        }

        return true;
    }


    private static function setCacheName(string $name): string
    {
        return config("laravel-localization.cache.prefix") . "_" . $name;
    }

    private static function setCacheTags(string $name): array
    {
        return [
            config("laravel-localization.cache.tag"),
            $name
        ];
    }
}
