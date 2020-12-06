<?php


namespace YusufOnur\LaravelLocalization\Traits;


use YusufOnur\LaravelLocalization\Models\Language;
use YusufOnur\LaravelLocalization\LaravelLocalization;
use YusufOnur\LaravelLocalization\DataTransferObjects\LanguageData;
use YusufOnur\LaravelLocalization\Support\CacheManagement\CacheManagement;

trait LanguageMetaTranslateResponseTrait
{
    public static function getLanguageMetaTranslatesRegular(
        LanguageData|Language|string|int|null $language = null
    )
    {
        $key = null;
        if ($language instanceof LanguageData or $language instanceof Language) {
            $key = $language->code;
        }
        if (is_string($language)) {
            $key = $language;
        }

        return CacheManagement::getOrCreateCacheValue("regular_".$key, function () use ($language) {
            $language = $language ? LanguageData::fromMixed($language) : null;

            $languageMetaTranslates = LaravelLocalization::getLanguageMetaTranslates($language);

            return self::setRegularData($language, $languageMetaTranslates);
        });
    }

    public static function setRegularData(LanguageData|null $languageData, $languageMetaTranslates): \Illuminate\Support\Collection
    {
        $result = [];
        foreach ($languageMetaTranslates as $item) {
            if (!isset($result[$item->language->code])) {
                $result[$item->language->code] = [];
            }
            $result[$item->language->code] = array_merge($result[$item->language->code], [
                $item->languageMeta->word => $item->word
            ]);
        }

        return collect($result);
    }
}
