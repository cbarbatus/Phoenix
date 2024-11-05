<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ritual extends Model
{
    public function venues()
    {
        return $this->hasMany(\App\Models\Venue::class);
    }

    public function announcements()
    {
        return $this->hasMany(\App\Models\Announcement::class);
    }
}
