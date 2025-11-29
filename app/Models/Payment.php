<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barter_id',
        'subscription_plan_id',
        'amount',
        'currency',
        'payment_method',
        'status',
        'provider_reference',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barter()
    {
        return $this->belongsTo(Barter::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(Subscription::class, 'subscription_plan_id');
    }
}
