<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'image',
        'heading',
        'subheading',
        'caption',
        'button_label',
        'button_url',
        'order',
        'status',
    ];

    protected $casts = [
        'order' => 'integer',
    ];
}
