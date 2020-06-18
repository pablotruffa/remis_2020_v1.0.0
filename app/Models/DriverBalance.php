<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class DriverBalance
{   
    protected $user;
    protected $reservations;
    protected $income;
    protected $expenses;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->reservations = $this->setReservations();
        $this->income = $this->setIncome();
        $this->expenses = $this->setExpenses();

    }

    public function getUser()
    {
        return $this->user;
    }

    public function getReservations()
    {
        return $this->reservations;
    }
    public function getIncome()
    {
        return $this->income;
    }
    public function getExpenses()
    {
        return $this->expenses;
    }

    protected function setReservations()
    {   
        $user = $this->user;
        return Reservation::whereHas('driver',function($q) use ($user){
            $q->where('drivers.email',$user->email);
        })->where('reservation_status',5)
        ->orderBy('updated_at','DESC')
        ->get();
    }

    public function setReservationsDate($from , $to)
    {
        $user = $this->user;
        $reservations = Reservation::whereHas('driver',function($q) use ($user){
            $q->where('drivers.email',$user->email);
        })
        ->where('reservation_status',5)
        ->whereBetween('travel_date',[$from,$to])
        ->orderBy('updated_at','DESC')
        ->get();

        $this->reservations = $reservations;
    }

    protected function setIncome()
    {   
        $income = 0;
        foreach($this->reservations as $reservation)
        {
            $income += $reservation->price / $reservation->vehicle_quantity;
        }
        return $income;
    }

    protected function setExpenses()
    {   
        $expenses = 0;
        foreach($this->reservations as $reservation)
        {
            $house_commission = ($reservation->price * $reservation->commission_percentage) / 100;
            $expenses += $house_commission / $reservation->vehicle_quantity;
        }
        return $expenses;
    }
}
