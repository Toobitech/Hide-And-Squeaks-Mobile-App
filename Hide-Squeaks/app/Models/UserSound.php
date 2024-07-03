<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSound extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the user associated with the UserSound
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function audio()
    {
        return $this->belongsTo(Audio::class);
    }
}
