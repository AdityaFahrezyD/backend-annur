<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';

    protected $fillable = [
        'title',
        'code',
        'level',
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
