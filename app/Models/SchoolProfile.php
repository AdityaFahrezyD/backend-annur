<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tagline',
        'description',
        'history',
        'vision',
        'missions',
        'address',
        'phone',
        'whatsapp',
        'email',
        'maps_embed_url',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'principal_name',
        'principal_title',
        'principal_message',
        'principal_photo',
        'accreditation',
        'npsn',
        'stats',
    ];

    protected $casts = [
        'missions' => 'array',
        'stats' => 'array',
    ];
}
