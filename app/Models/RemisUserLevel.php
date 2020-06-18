<?php

namespace App\Models;

use App\Models\RemisUsers;
use Illuminate\Database\Eloquent\Model;

class RemisUserLevel extends Model
{
    protected $table = 'user_level';

    public function user()
    {
        return $this->belongsTo(RemisUsers::class,'id','level_id');
    }
}
