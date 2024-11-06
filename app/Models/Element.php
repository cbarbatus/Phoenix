<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Element extends Model
{
    use HasFactory;

    protected $fillable = ['section_id', 'name', 'slug', 'title', 'item'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Section::class);
    }
}
