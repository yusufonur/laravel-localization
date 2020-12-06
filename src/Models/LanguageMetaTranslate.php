<?php

namespace YusufOnur\LaravelLocalization\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LanguageMetaTranslate extends Model
{
    protected $fillable = [
        "language_id",
        "language_meta_id",
        "word"
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function languageMeta(): BelongsTo
    {
        return $this->belongsTo(LanguageMeta::class);
    }
}
