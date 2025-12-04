<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'video_urls',
    ];

    protected $casts = [
        'video_urls' => 'array',
    ];

    public function videos()
    {
        return $this->hasMany(PageVideo::class);
    }
}
