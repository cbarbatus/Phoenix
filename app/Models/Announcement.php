<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    public function ritual()
    {
        return $this->belongsTo(\App\Models\Ritual::class);
    }
}
