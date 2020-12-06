<?php


namespace YusufOnur\LaravelLocalization\Traits;


use YusufOnur\LaravelLocalization\Models\Language;
use YusufOnur\LaravelLocalization\Support\CacheManagement\CacheManagement;

trait LanguageTrait
{
    public static function getLanguages(): \Illuminate\Database\Eloquent\Collection|array
    {
        return CacheManagement::getOrCreateCacheValue(self::getLanguageCacheTag(), function () {
            return Language::all();
        });
    }

    public static function createLanguage(string $language, string $code): \Illuminate\Database\Eloquent\Model|static
    {
        self::flushLanguageCache();

        return Language::query()
            ->firstOrCreate([
                "name" => $language,
                "code" => $code
            ]);
    }

    public static function destroyLanguage(Language|string $language, bool $cacheFlush = true): mixed
    {
        $cacheFlush ? self::flushLanguageCache() : null;

        if ($language instanceof Language) {
            return $language->delete();
        }

        if (is_string($language)) {
            return Language::query()
                ->where("code", $language)
                ->delete();
        }
    }

    public static function destroyLanguages(array $languages): void
    {
        foreach ($languages as $language) {
            self::destroyLanguage($language, false);
        }

        self::flushLanguageCache();
    }

    private static function flushLanguageCache()
    {
        CacheManagement::flushCache(self::getLanguageCacheTag());
    }

    private static function getLanguageCacheTag(string|null $suffix = null): string
    {
        $suffix = $suffix ? "_" . $suffix : "";

        return config("laravel-localization.tables.languages") . $suffix;
    }
}
