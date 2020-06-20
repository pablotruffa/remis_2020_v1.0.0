<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReservationLog
 *
 * @property int $id
 * @property int $confirmation_number
 * @property string $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereConfirmationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReservationLog extends Model
{       
    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = 'reservation_logs';
    
    /**
     * @var array campos de asignación masiva permitida.
     */
    protected $fillable = ['confirmation_number','data'];

}
