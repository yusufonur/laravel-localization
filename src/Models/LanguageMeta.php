<?php

namespace YusufOnur\LaravelLocalization\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LanguageMeta extends Model
{
    protected $fillable = [
        "language_id",
        "word"
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
