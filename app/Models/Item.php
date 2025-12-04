<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'sub_category_id',
        'title',
        'description',
        'condition_id',
        'size_id',
        'brand_id',
        'item_status_id',
        'color_id',
        'city_id',
        'location_area',
    ];

    protected $casts = [
        //
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function itemStatus()
    {
        return $this->belongsTo(ItemStatus::class);
    }

    public function images()
    {
        return $this->hasMany(ItemImage::class)->orderBy('sort_order');
    }

    public function primaryImage()
    {
        return $this->hasOne(ItemImage::class)->where('is_primary', true);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id')->withTimestamps();
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
