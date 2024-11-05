<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Motion extends Model
{
    protected $fillable = ['member_id', 'item', 'motion_date'];
}
