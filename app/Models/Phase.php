<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'phase';

    protected $fillable = [
        'title',
        'phase_name',
        'code',
        'description',
        'features',
        'order',
        'status',
    ];

    protected $casts = [
        'features' => 'array',
        'order' => 'integer',
    ];
}
