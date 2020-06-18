<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Driver;
use App\Models\RemisUsers;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;

class Audit
{   
    protected $from;
    protected $to;
    protected $reservations;
    protected $status;
    protected $globalIncome;
    protected $expectedIncome;
    protected $lostIncome;
    protected $houseIncome;
    protected $driversIncome;
    
    

    public function __construct(array $dates = null)
    {
        $this->setDates($dates);
        $this->setReservations($dates);
        $this->setStatus();
        $this->setIncome();
    }

    public function getFrom()
    {
        return $this->from;
    
    }
    public function getTo()
    {
        return $this->to;
    }

    public function getReservations()
    {
        return $this->reservations;
    }

    public function getCompletedReservations()
    {
        $completed = [];
        foreach($this->reservations as $reservation)
        {
            if($reservation->reservation_status == 5)
            {
                $completed[]=$reservation;
            }
        }
        return $completed;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getGlobalIncome()
    {
        return $this->globalIncome;
    }

    public function getExpectedIncome()
    {
        return $this->expectedIncome;
    }

    public function getHouseIncome()
    {
        return $this->houseIncome;
    }

    public function getDriversIncome()
    {
        return $this->driversIncome;
    }

    protected function setDates($dates = null)
    {
        if(!$dates){
            $this->from = date('Y-m-d',time());
            $this->to   = date('Y-m-d',time());
        }else{
            $this->from = $dates['from'];
            $this->to   = $dates['to'];;
        }
    }

    protected function setReservations()
    {
        $this->reservations = Reservation::whereBetween('travel_date',[$this->from,$this->to])->orderBy('travel_date','DESC')->get();
    }

    public function setStatus()
    {   
        $status = [
            'Confirmadas'   => 0,
            'Iniciadas'     => 0,
            'Postergadas'   => 0,
            'Canceladas'    => 0,
            'Concretadas'   => 0,
        ];
        foreach($this->reservations as $reservation)
        {
            switch($reservation->reservation_status)
            {
                case 1: $status['Confirmadas']  += 1; break;
                case 2: $status['Iniciadas']    += 1; break;
                case 3: $status['Postergadas']  += 1; break;
                case 4: $status['Canceladas']   += 1; break;
                case 5: $status['Concretadas']  += 1; break;
            }
        }
        $this->status = $status;
    }

    protected function setIncome()
    {
        $globalIncome   = 0;
        $expectedIncome = 0;
        $houseIncome    = 0;
        $driversIncome  = 0;
        
        foreach($this->reservations as $reservation)
        {
            if($reservation->reservation_status == 5)
            {
                $globalIncome   += $reservation->price;
                $houseIncome    += $this->getHouseShare($reservation);
                $driversIncome  += $this->getDriversShare($reservation);
            }
            
            if( in_array($reservation->reservation_status,[1,2,3,5]) )
            {
                $expectedIncome += $reservation->price;
            }
        
        }
        $this->globalIncome     = $globalIncome;
        $this->houseIncome      = $houseIncome;
        $this->driversIncome    = $driversIncome;
        $this->expectedIncome   = $expectedIncome;
    }

    protected function getHouseShare($reservation)
    {
        return $reservation->price * $reservation->commission_percentage / 100;
    }

    protected function getDriversShare($reservation)
    {
        $commission = $this->getHouseShare($reservation);
        return $reservation->price - $commission;
    }
    
}
