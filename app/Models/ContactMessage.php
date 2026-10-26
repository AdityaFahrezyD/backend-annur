<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'visitor_name',
        'email',
        'phone',
        'subject',
        'message',
        'ip_address',
        'crm_status',
        'priority',
        'handled_by',
        'last_contacted_at',
    ];

    protected $casts = [
        'last_contacted_at' => 'datetime',
    ];

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function notes()
    {
        return $this->hasMany(ContactNote::class)->orderBy('created_at', 'desc');
    }
}
