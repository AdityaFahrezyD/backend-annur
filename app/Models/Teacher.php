<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'nip',
        'subject',
        'role_title',
        'education',
        'photo',
        'bio',
        'gender',
        'certifications',
        'experience',
        'is_leadership',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'certifications' => 'array',
        'is_leadership' => 'boolean',
        'order' => 'integer',
    ];

    public function principals(): HasMany
    {
        return $this->hasMany(Principal::class);
    }
}
