<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Principal extends Model
{
    use HasFactory, HasUuids;

    protected $appends = [
        'name',
        'education',
        'experience',
        'bio',
        'photo',
    ];

    protected $hidden = ['teacher'];

    protected $fillable = [
        'school_profile_id',
        'teacher_id',
        'title',
        'message',
        'started_at',
        'ended_at',
        'is_current',
    ];

    protected $casts = [
        'started_at' => 'date:Y-m-d',
        'ended_at' => 'date:Y-m-d',
        'is_current' => 'boolean',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    public function schoolProfile(): BelongsTo
    {
        return $this->belongsTo(SchoolProfile::class);
    }

    public function getNameAttribute(): ?string
    {
        return $this->teacher?->name;
    }

    public function getEducationAttribute(): ?string
    {
        return $this->teacher?->education;
    }

    public function getExperienceAttribute(): ?string
    {
        return $this->teacher?->experience;
    }

    public function getBioAttribute(): ?string
    {
        return $this->teacher?->bio;
    }

    public function getPhotoAttribute(): ?string
    {
        return $this->teacher?->photo;
    }
}
