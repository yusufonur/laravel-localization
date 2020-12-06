<?php


function ll(string $dotNotation) {
    $explode = explode(".", $dotNotation);
    $lang = app()->getLocale() ?? current($explode);
    $name = end($explode);

    try {
        $metaTranslates = YusufOnur\LaravelLocalization\LaravelLocalization::getLanguageMetaTranslatesRegular($lang);
    } catch (Exception $error) {
        return $name;
    }

    return $metaTranslates->get($lang)[$name] ?? $name;
}
