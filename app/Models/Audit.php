<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Driver;
use App\Models\RemisUsers;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;

class Audit
{   
        
        
    /**
     * from
     *
     * @var string la fecha "desde".
     */
    protected $from;    
    
    /**
     * to
     *
     * @var string la fecha "hasta".
     */
    protected $to;    
    
    /**
     * reservations
     *
     * @var mixed Collección de reservas.
     */
    protected $reservations;    
    
    /**
     * status
     *
     * @var array Status general de todas las reservas.
     */
    protected $status;    
    
    /**
     * globalIncome
     *
     * @var mixed Ingresos general.
     */
    protected $globalIncome;    
    
    /**
     * expectedIncome
     *
     * @var mixed Ingresos esperados.
     */
    protected $expectedIncome;       
    
    /**
     * houseIncome
     *
     * @var mixed Ingresos de la Remiseria.
     */
    protected $houseIncome;    
    
    /**
     * driversIncome
     *
     * @var mixed Ingresos de los choferes.
     */
    protected $driversIncome;
    
    
    
    /**
     * __construct
     *
     * @param  array $dates Fechas desde y hasta del formulario.
     * @return void
     */
    public function __construct(array $dates = null)
    {
        $this->setDates($dates);
        $this->setReservations($dates);
        $this->setStatus();
        $this->setIncome();
    }
        
    /**
     * Busca la fecha desde.
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->from;

    }
        
    /**
     * Busca la propiedad to/hasta
     *
     * @return string
     */
    public function getTo()
    {
        return $this->to;
    }
    
    /**
     * Busca las reservas
     *
     * @return array
     */
    public function getReservations()
    {
        return $this->reservations;
    }
    
    /**
     * getCompletedReservations Busca las reservas con status 5
     *
     * @return array
     */
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
    
    /**
     * getStatus Busca todos los estados
     *
     * @return array
     */
    public function getStatus()
    {
        return $this->status;
    }
    
    /**
     * getGlobalIncome Busca los ingresos.
     * 
     * @return integer|float
     */
    public function getGlobalIncome()
    {
        return $this->globalIncome;
    }
    
    /**
     * getExpectedIncome Busca las ganancias especuladas.
     *
     * @return integer|float
     */
    public function getExpectedIncome()
    {
        return $this->expectedIncome;
    }
    
    /**
     * getHouseIncome Filtra los ingresos de la Remisería.
     *
     * @return integer|float
     */
    public function getHouseIncome()
    {
        return $this->houseIncome;
    }
    
    /**
     * getDriversIncome Filtra los ingresos de los choferes.
     *
     * @return integer|float
     */
    public function getDriversIncome()
    {
        return $this->driversIncome;
    }
    
    /**
     * setDates Setea las propiedades $from y $to para filtrar la busqueda de las reservas.
     *
     * @param  mixed
     * @return void
     */
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
    
    /**
     * setReservations Setea la propiedad $reservations.
     *
     * @return void
     */
    protected function setReservations()
    {
        $this->reservations = Reservation::whereBetween('travel_date',[$this->from,$this->to])->orderBy('travel_date','DESC')->get();
    }
    
    /**
     * setStatus Setea la propiedad $status
     *
     * @return void
     */
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
    
    /**
     * setIncome Setea las propiedadaes $globalIncome, $expectedIncome, $houseIncome,$driversIncome
     *
     * @return void
     */
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
    
    /**
     * getHouseShare Retorna los ingresos de la remisería.
     *
     * @param  array $reservation
     * @return mixed
     */
    protected function getHouseShare($reservation)
    {
        return $reservation->price * $reservation->commission_percentage / 100;
    }
    
    /**
     * getDriversShare Retorna los ingresos de los choferes.
     *
     * @param  mixed $reservation
     * @return void
     */
    protected function getDriversShare($reservation)
    {
        $commission = $this->getHouseShare($reservation);
        return $reservation->price - $commission;
    }
    
}
