<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'avatar',
        'country',
        'city',
        'address',
        'status',
        'average_rating',
        'completed_trades_count',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'average_rating' => 'float',
        'completed_trades_count' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function bartersSent()
    {
        return $this->hasMany(Barter::class, 'requester_id');
    }

    public function bartersReceived()
    {
        return $this->hasMany(Barter::class, 'receiver_id');
    }

    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'from_user_id');
    }

    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'to_user_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id')->withTimestamps();
    }

    public function wants()
    {
        return $this->hasMany(UserWant::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(UserSubscription::class)->where('status', 'active')->latestOfMany();
    }
    public function canAccessPanel(User $user): bool
    {
        return str_ends_with($user->email, 'admin@admin.com') && $user->hasVerifiedEmail();
    }
}
