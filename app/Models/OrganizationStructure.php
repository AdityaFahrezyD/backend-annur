<?php

namespace App\Models;

use Database\Factories\OrganizationStructureFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrganizationStructure extends Model
{
    /** @use HasFactory<OrganizationStructureFactory> */
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'position',
        'image',
        'parent_id',
        'order',
        'status',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')
            ->orderBy('order')
            ->orderBy('id');
    }
}
