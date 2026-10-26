<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'category',
        'image',
        'description',
        'event_date',
        'status',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];
}
