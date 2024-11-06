<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Ritual extends Model
{
    public function venues(): HasMany
    {
        return $this->hasMany(\App\Models\Venue::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(\App\Models\Announcement::class);
    }
}
