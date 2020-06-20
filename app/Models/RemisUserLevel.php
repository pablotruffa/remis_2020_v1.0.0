<?php

namespace App\Models;

use App\Models\RemisUsers;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RemisUserLevel
 *
 * @property int $id
 * @property string $level
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RemisUsers $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUserLevel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RemisUserLevel extends Model
{   
    /** @var string La tabla que comunica al modelo.  */
    protected $table = 'user_level';
    
    /**
     * Relación de Eloquent
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(RemisUsers::class,'id','level_id');
    }
}
