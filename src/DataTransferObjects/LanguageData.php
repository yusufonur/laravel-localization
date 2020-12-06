<?php


namespace YusufOnur\LaravelLocalization\DataTransferObjects;


use YusufOnur\LaravelLocalization\Models\Language;
use YusufOnur\LaravelLocalization\Support\DataTransferObject\DataTransferObject;

class LanguageData extends DataTransferObject
{
    public int $id;
    public string $name;
    public string $code;

    public static function fromMixed(LanguageData|Language|string|int $language): self
    {
        if ($language instanceof LanguageData) {
            return $language;
        }

        if (is_string($language)) {
            $language = Language::query()
                ->where("code", $language)
                ->firstOrFail();
        }

        if (is_int($language)) {
            $language = Language::query()->findOrFail($language);
        }

        return new self([
            "id" => $language?->id,
            "name" => $language?->name,
            "code" => $language?->code
        ]);
    }
}
