<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SchoolProfile extends Model
{
    use HasFactory, HasUuids;

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
        'accreditation',
        'npsn',
        'stats',
    ];

    protected $casts = [
        'missions' => 'array',
        'stats' => 'array',
    ];

    protected $appends = [
        'principal_name',
        'principal_title',
        'principal_message',
        'principal_photo',
    ];

    public function principalHistory(): HasMany
    {
        return $this->hasMany(Principal::class)
            ->orderByDesc('is_current')
            ->orderByDesc('started_at')
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }

    public function currentPrincipal(): HasOne
    {
        return $this->hasOne(Principal::class)->where('is_current', true);
    }

    public function getPrincipalNameAttribute(): ?string
    {
        return $this->currentPrincipal?->name;
    }

    public function getPrincipalTitleAttribute(): ?string
    {
        return $this->currentPrincipal?->title;
    }

    public function getPrincipalMessageAttribute(): ?string
    {
        return $this->currentPrincipal?->message;
    }

    public function getPrincipalPhotoAttribute(): ?string
    {
        return $this->currentPrincipal?->photo;
    }
}
