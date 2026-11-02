<?php

namespace App\Models;

use Database\Factories\ExtracurricularFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Extracurricular extends Model
{
    /** @use HasFactory<ExtracurricularFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'order',
        'status',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function images(): MorphMany
    {
        return $this->morphMany(ExtracurricularImage::class, 'imageable')
            ->orderBy('order')
            ->orderBy('id');
    }
}
