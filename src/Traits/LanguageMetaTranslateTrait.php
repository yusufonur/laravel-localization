<?php


namespace YusufOnur\LaravelLocalization\Traits;


use YusufOnur\LaravelLocalization\Models\Language;
use YusufOnur\LaravelLocalization\Models\LanguageMeta;
use YusufOnur\LaravelLocalization\Models\LanguageMetaTranslate;
use YusufOnur\LaravelLocalization\DataTransferObjects\LanguageData;
use YusufOnur\LaravelLocalization\DataTransferObjects\LanguageMetaData;
use YusufOnur\LaravelLocalization\Support\CacheManagement\CacheManagement;

trait LanguageMetaTranslateTrait
{
    use LanguageMetaTranslateResponseTrait;

    public static function getLanguageMetaTranslates(
        LanguageData|Language|string|int|null $language = null
    ): mixed
    {
        $language = $language ? LanguageData::fromMixed($language) : null;

        return CacheManagement::getOrCreateCacheValue(self::getLanguageMetaTranslateCacheTag($language?->code), function () use ($language) {
            return LanguageMetaTranslate::query()
                ->when($language, function ($query) use ($language) {
                    return $query->where("language_id", $language->id);
                })->with(["language", "languageMeta"])
                ->get();
        });
    }

    public static function createLanguageMetaTranslate(
        Language|string|int|null $language,
        LanguageMeta|int $languageMeta,
        string $word
    ): \Illuminate\Database\Eloquent\Model|static
    {
        self::flushLanguageMetaTranslateCache();

        $language = $language ? LanguageData::fromMixed($language) : null;
        $languageMeta = LanguageMetaData::fromMixed($languageMeta);

        return LanguageMetaTranslate::query()
            ->firstOrCreate([
                "language_id" => $language->id,
                "language_meta_id" => $languageMeta->id,
                "word" => $word
            ]);
    }

    public static function destroyLanguageMetaTranslate(
        LanguageMetaTranslate|int $languageMetaTranslate,
        bool|null $flushLanguageMetaTranslateCache = true
    ): mixed
    {
        $flushLanguageMetaTranslateCache ? self::flushLanguageMetaTranslateCache() : null;

        if ($languageMetaTranslate instanceof LanguageMeta) {
            return $languageMetaTranslate->delete();
        }

        return LanguageMetaTranslate::query()
            ->where("id", $languageMetaTranslate)
            ->delete();
    }

    public static function destroyLanguageMetaTranslates(array $languageMetaTranslates): void
    {
        foreach ($languageMetaTranslates as $languageMetaTranslate) {
            self::destroyLanguageMetaTranslate($languageMetaTranslate, false);
        }

        self::flushLanguageMetaTranslateCache();
    }

    private static function flushLanguageMetaTranslateCache()
    {
        CacheManagement::flushCache(self::getLanguageMetaTranslateCacheTag());
    }

    private static function getLanguageMetaTranslateCacheTag(string|null $suffix = null): string
    {
        $suffix = $suffix ? "_" . $suffix : "";

        return config("laravel-localization.tables.language_meta_translates") . $suffix;
    }
}
