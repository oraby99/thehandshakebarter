<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'video_urls',
        'is_published',
    ];

    protected $casts = [
        'video_urls' => 'array',
        'is_published' => 'boolean',
    ];

    public function videos()
    {
        return $this->hasMany(PageVideo::class);
    }
}
