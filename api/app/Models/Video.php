<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'video_id',
        'title',
        'description',
        'thumbnail_url',
        'thumbnail_height',
        'thumbnail_width',
        'published_at'
    ];

    public function video_tag_mst() {
        return $this->hasMany(VideoTagMst::class);
    }
}