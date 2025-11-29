<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barter extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'requester_id',
        'receiver_id',
        'requester_item_id',
        'receiver_item_id',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        //
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function requesterItem()
    {
        return $this->belongsTo(Item::class, 'requester_item_id');
    }

    public function receiverItem()
    {
        return $this->belongsTo(Item::class, 'receiver_item_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function conversation()
    {
        return $this->hasOne(Conversation::class);
    }
}
