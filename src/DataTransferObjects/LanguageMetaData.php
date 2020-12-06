<?php


namespace YusufOnur\LaravelLocalization\DataTransferObjects;


use YusufOnur\LaravelLocalization\Models\LanguageMeta;
use YusufOnur\LaravelLocalization\Support\DataTransferObject\DataTransferObject;

class LanguageMetaData extends DataTransferObject
{
    public int $id;
    public string $word;

    public static function fromMixed(LanguageMeta|int $languageMeta): self
    {
        if (is_int($languageMeta)) {
            $languageMeta = LanguageMeta::query()->findOrFail($languageMeta);
        }

        return new self([
            "id" => $languageMeta?->id,
            "word" => $languageMeta?->word
        ]);
    }
}
