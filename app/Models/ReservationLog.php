<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ReservationLog extends Model
{
    protected $table = 'reservation_logs';
    
    protected $fillable = ['confirmation_number','data'];

}
