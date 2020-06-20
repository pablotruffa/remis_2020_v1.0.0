<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ReservationStatus
 *
 * @property int $id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReservationStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReservationStatus extends Model
{   
    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = 'reservation_status';
}
