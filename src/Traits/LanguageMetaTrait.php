<?php


namespace YusufOnur\LaravelLocalization\Traits;


use YusufOnur\LaravelLocalization\Models\Language;
use YusufOnur\LaravelLocalization\Models\LanguageMeta;
use YusufOnur\LaravelLocalization\Support\CacheManagement\CacheManagement;

trait LanguageMetaTrait
{
    public static function getLanguageMetas()
    {
        return CacheManagement::getOrCreateCacheValue(self::getLanguageMetaCacheTag(), function () {
            return LanguageMeta::query()->get();
        });
    }

    public static function createLanguageMeta(string $word): LanguageMeta
    {
        self::flushLanguageMetaCache();

        return LanguageMeta::query()
            ->firstOrCreate([
                "word" => $word
            ]);
    }

    public static function destroyLanguageMeta(LanguageMeta|int $languageMeta, bool $flushLanguageMetaCache = true): mixed
    {
        $flushLanguageMetaCache ? self::flushLanguageMetaCache() : null;

        if ($languageMeta instanceof Language) {
            return $languageMeta->delete();
        }

        return LanguageMeta::query()
            ->where("id", $languageMeta)
            ->delete();
    }

    public static function destroyLanguageMetas(array $languageMetas): void
    {
        foreach ($languageMetas as $languageMeta) {
            self::destroyLanguageMeta($languageMeta, false);
        }

        self::flushLanguageMetaCache();
    }

    private static function flushLanguageMetaCache()
    {
        CacheManagement::flushCache(self::getLanguageMetaCacheTag());
    }

    private static function getLanguageMetaCacheTag(string|null $suffix = null): string
    {
        $suffix = $suffix ? "_" . $suffix : "";

        return config("laravel-localization.tables.language_metas") . $suffix;
    }
}
