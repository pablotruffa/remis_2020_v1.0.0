<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class DriverBalance
{   
    /** @var object $user   */
    protected $user;
    
    /** @var array $reservations */
    protected $reservations;

    /** @var mixed $income */
    protected $income;

    /** @var mixed $expenses */
    protected $expenses;

    public function __construct()
    {
        $this->user = Auth::user();
        $this->reservations = $this->setReservations();
        $this->income = $this->setIncome();
        $this->expenses = $this->setExpenses();

    }
    
    /**
     * Retorna el usuario
     *
     * @return void
     */
    public function getUser()
    {
        return $this->user;
    }
    
    /**
     * getReservations Retorna las reservas.
     *
     * @return array
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    
    /**
     * getIncome Retorna los ingresos.
     *
     * @return mixed
     */
    public function getIncome()
    {
        return $this->income;
    }

        
    /**
     * getExpenses Retorna los gastos.
     *
     * @return mixed
     */
    public function getExpenses()
    {
        return $this->expenses;
    }

        
    /**
     * setReservations retorna un array de reservas.     *
     * @return array
     */
    protected function setReservations()
    {   
        $user = $this->user;
        return Reservation::whereHas('driver',function($q) use ($user){
            $q->where('drivers.email',$user->email);
        })->where('reservation_status',5)
        ->orderBy('updated_at','DESC')
        ->get();
    }
    
    /**
     * setReservationsDate Setea la propiedad $reservations
     *
     * @param  string $from
     * @param  string $to
     * @return void
     */
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
    
    /**
     * setIncome Retorna los ingresos
     *
     * @return mixed
     */
    protected function setIncome()
    {   
        $income = 0;
        foreach($this->reservations as $reservation)
        {
            $income += $reservation->price / $reservation->vehicle_quantity;
        }
        return $income;
    }

    /**
     * setExpenses Retorna los gastos
     *
     * @return mixed
     */
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
