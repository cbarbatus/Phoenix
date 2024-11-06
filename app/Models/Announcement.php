<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    public function ritual(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Ritual::class);
    }
}
