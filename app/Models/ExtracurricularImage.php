<?php

namespace App\Models;

use Database\Factories\ExtracurricularImageFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ExtracurricularImage extends Model
{
    /** @use HasFactory<ExtracurricularImageFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'path',
        'alt_text',
        'order',
    ];

    protected $appends = ['url'];

    protected $casts = [
        'order' => 'integer',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getUrlAttribute(): string
    {
        return filter_var($this->path, FILTER_VALIDATE_URL)
            ? $this->path
            : asset('storage/'.$this->path);
    }
}
