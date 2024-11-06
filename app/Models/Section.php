<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'sequence'];

    public function elements(): HasMany
    {
        return $this->hasMany(\App\Models\Element::class);
    }
}
