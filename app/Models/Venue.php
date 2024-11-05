<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    public function ritual()
    {
        return $this->belongsTo(\App\Models\Ritual::class);
    }
}
