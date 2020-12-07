<?php


use YusufOnur\LaravelLocalization\LaravelLocalization;

function __local(string $dotNotation) {
    $explode = explode(".", $dotNotation);
    $lang = app()->getLocale() ?? current($explode);
    $name = end($explode);

    try {
        $metaTranslates = LaravelLocalization::getLanguageMetaTranslatesRegular($lang);
    } catch (Exception $error) {
        return $name;
    }

    return $metaTranslates->get($lang)[$name] ?? $name;
}
