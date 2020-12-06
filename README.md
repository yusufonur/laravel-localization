# Laravel localization

[![Latest Version on Packagist](https://img.shields.io/packagist/v/yusufonur/laravel-localization.svg?style=flat-square)](https://packagist.org/packages/yusufonur/laravel-localization)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/yusufonur/laravel-localization/run-tests?label=tests)](https://github.com/yusufonur/laravel-localization/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/yusufonur/laravel-localization.svg?style=flat-square)](https://packagist.org/packages/yusufonur/laravel-localization)


This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.


## Installation

You can install the package via composer:

```bash
composer require yusufonur/laravel-localization
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="YusufOnur\LaravelLocalization\LaravelLocalizationServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="YusufOnur\LaravelLocalization\LaravelLocalizationServiceProvider" --tag="config"
```



## Usage

``` php
$turkish = LaravelLocalization::createLanguage("Türkçe", "tr");
$english = LaravelLocalization::createLanguage("İngilizce", "en");

$metaHome = LaravelLocalization::createLanguageMeta("home");
$metaContact = LaravelLocalization::createLanguageMeta("Contact");

LaravelLocalization::createLanguageMetaTranslate($turkish, $metaHome, "Anasayfa");
LaravelLocalization::createLanguageMetaTranslate($turkish, $metaContact, "İletişim");
LaravelLocalization::createLanguageMetaTranslate($english, $metaHome, "Home");
LaravelLocalization::createLanguageMetaTranslate($english, $metaContact, "Contact");

return LaravelLocalization::getLanguageMetaTranslatesRegular();
    /*
        {
          "en": {
            "home": "Home",
            "Contact": "Contact"
          },
          "tr": {
            "home": "Anasayfa",
            "Contact": "İletişim"
          }
        }
    */
```

##Helper Usage
```
    {{ ll("home") }} 
```
If default language (you can get with app()->getLocale()) then result is **tr**: "Anasayfa"

If getLocale then result is **en**: "Home"

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Yusuf Onur SARI](https://github.com/yusufonur)
- [All Contributors](../../contributors)

