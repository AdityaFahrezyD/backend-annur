<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactNote extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'contact_message_id',
        'user_id',
        'author_name',
        'note',
    ];

    public function message()
    {
        return $this->belongsTo(ContactMessage::class, 'contact_message_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
