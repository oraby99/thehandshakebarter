<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'barter_id',
    ];

    public function barter()
    {
        return $this->belongsTo(Barter::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
