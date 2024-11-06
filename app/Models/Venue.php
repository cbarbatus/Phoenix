<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    public function ritual(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Ritual::class);
    }
}
