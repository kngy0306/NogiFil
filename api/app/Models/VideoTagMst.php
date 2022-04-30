<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoTagMst extends Model
{
    use HasFactory;

    protected $table = 'video_tag_mst';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'video_id',
        'tag_id'
    ];

    public function tag() {
        return $this->hasMany(Tag::class);
    }
}