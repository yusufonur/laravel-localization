<?php

namespace YusufOnur\LaravelLocalization\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    protected $fillable = [
        "name",
        "code"
    ];

    public function languageMetaTranslates(): HasMany
    {
        return $this->hasMany(LanguageMetaTranslate::class);
    }
}
