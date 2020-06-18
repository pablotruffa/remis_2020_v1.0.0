<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationStatus;

class ReservationStatusController extends Controller
{
    public function index()
    {   
        $status = ReservationStatus::all();
        return view('reservations.statusList', compact('status'));
    }
}
