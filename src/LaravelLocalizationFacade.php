<?php

namespace YusufOnur\LaravelLocalization;

use Illuminate\Support\Facades\Facade;

/**
 * @see \YusufOnur\LaravelLocalization\LaravelLocalization
 */
class LaravelLocalizationFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravelLocalization';
    }
}
