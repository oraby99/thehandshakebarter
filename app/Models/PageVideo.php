<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageVideo extends Model
{
    use HasFactory;

    protected $fillable = ['page_id', 'video_url', 'description'];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
