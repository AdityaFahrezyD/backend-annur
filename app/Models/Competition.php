<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'organizer',
        'category',
        'description',
        'registration_deadline',
        'event_date',
        'location',
        'guide_book_url',
        'banner_image',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'registration_deadline' => 'date',
        'event_date' => 'date',
        'is_featured' => 'boolean',
    ];
}
