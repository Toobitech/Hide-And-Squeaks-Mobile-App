<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get all of the comments for the Video
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function views()
    {
        return $this->hasMany(View::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
