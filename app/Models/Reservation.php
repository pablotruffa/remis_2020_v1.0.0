<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Driver;
use App\Models\ReservationLog;
use App\Models\ReservationStatus;
use App\Models\CancellationReason;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reservation
 *
 * @property int $id
 * @property int $confirmation_number
 * @property string $travel_date
 * @property string $travel_time
 * @property string $origin
 * @property string $destiny
 * @property int $vehicle_quantity
 * @property float $price
 * @property float $commission_percentage
 * @property int $reservation_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CancellationReason[] $cancellation
 * @property-read int|null $cancellation_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $client
 * @property-read int|null $client_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Driver[] $driver
 * @property-read int|null $driver_count
 * @property-read \App\Models\ReservationLog|null $log
 * @property-read \App\Models\ReservationStatus $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereCommissionPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereConfirmationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereDestiny($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereOrigin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereReservationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereTravelDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereTravelTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reservation whereVehicleQuantity($value)
 * @mixin \Eloquent
 */
class Reservation extends Model
{   
    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = 'reservations';
    
    /**
     * @var array campo de asignación masiva permitida.
     */
    protected $fillable = [
        'confirmation_number',
        'travel_date',
        'travel_time',
        'origin',
        'destiny',
        'vehicle_quantity',
        'price',
        'commission_percentage',
        'reservation_status',
    ]; 

    /**
     * @static $rules reglas de validación.
     */
    public static $rules = [
        'travel_date'           =>'required|date_format:Y-m-d',
        'travel_time'           =>'required|date_format:H:i',
        'origin'                =>'required|string|min:2|max:300',
        'destiny'               =>'required|string|min:2|max:300',
        'vehicle_quantity'      =>'required|numeric|integer|between:1,10',
        'price'                 =>'required|numeric|between:0,500000.00',
        'commission_percentage' =>'required|numeric|between:0,100',
        'id_client'         => array(
                                'required',
                                'numeric',
                                'integer',
                                'regex:/^[1-9]+\d*/'
                            ),
    ];

    /**
     * @static $driver_assign_radio_rules reglas de validación.
     */
    public static $driver_assign_radio_rules =[
        'driver' => array(
            'required',
            'numeric',
            'integer',
            'regex:/^[1-9]+\d*/'
        ),
    ];

    /**
     * @static $driver_assign_checkbox_rules reglas de validación.
     */
    public static $driver_assign_checkbox_rules =[
        'driver' => 'required|array',
        'driver.*' => array(
                            'required',
                            'numeric',
                            'integer',
                            'regex:/^[1-9]+\d*/'
                        ),
    ];

    /**
     * @static $messages mensajes de validación.
     */
    public static $messages = [
        'travel_date.required'      => 'El campo no puede quedar vacío.',
        'travel_date.date_format'   => 'No cumple el formato de fecha.',

        'travel_time.required'      => 'El campo no puede quedar vacío.',
        'travel_time.date_format'   => 'No cumple el formato horario.',
        
        
        'origin.required'           => 'El campo no puede quedar vacío.',
        'origin.min'                => 'El origen debe tener al menos 2 caracteres.',
        'origin.max'                => 'El origen debe tener como máximo 200 caracteres.',
        'origin.string'             => 'No cumple el formato de texto.',
        
        'destiny.required'          => 'El campo no puede quedar vacío.',
        'destiny.min'               => 'El origen debe tener al menos 2 caracteres.',
        'destiny.max'               => 'La destino debe tener como máximo 200 caracteres.',
        'destiny.string'            => 'No cumple el formato de texto.',
        
        'vehicle_quantity.required' => 'El campo no puede quedar vacío.',
        'vehicle_quantity.numeric'  => 'El campo debe ser numérico',
        'vehicle_quantity.integer'  => 'El valor debe ser un número entero',
        'vehicle_quantity.between'  => 'La cantidad debe ser entre 1 y 10.',
        
        'price.required'            => 'El campo no puede quedar vacío.',
        'price.between'             => 'El precio debe ser entre 0 y 500.000,00.',

        'commission_percentage.required'            => 'El campo no puede quedar vacío.',
        'commission_percentage.between'             => 'Se espera un número entre 0 y 100',
        
        'id_client.required'        => 'El campo no puede quedar vacío.',
        'id_client.numeric'         => 'El campo debe ser numérico',
        'id_client.integer'         => 'El valor debe ser un número entero',
        'id_client.regex'           => 'El valor debe ser un número entero positivo',

        'driver.required'           =>'Es necesario elegir una opción',
    
    ];

        
    /**
     * Relación de Eloquent
     *
     * @return void
     */
    public function log()
    {
        return $this->hasOne(ReservationLog::class,'confirmation_number','confirmation_number');
    }

     /**
     * Relación de Eloquent
     *
     * @return void
     */
    public function status()
    {
        return $this->belongsTo(ReservationStatus::class,'reservation_status','id');
    }

     /**
     * Relación de Eloquent
     *
     * @return void
     */
    public function client()
    {   

        /**
         * Clase
         * Tabla Pivot
         * FK en la tabla pivot que relaciona a este modelo (Reservation)
         * FK en la tabla pivot que relaciona a el otro modelo (Client)
         */
        return $this->belongsToMany(Client::class, 'reservation_has_client','reservation_id','client_id')->withTrashed()->withTimestamps();
    }

     /**
     * Relación de Eloquent
     *
     * @return void
     */
    public function cancellation()
    {
        return $this->belongsToMany(CancellationReason::class, 'reservation_has_cancellation','reservation_id','reason_id')->withPivot('remark')->withTimestamps();
    }

     /**
     * Relación de Eloquent
     *
     * @return void
     */
    public function driver()
    {
        return $this->belongsToMany(Driver::class,'reservation_has_driver','reservation_id','driver_id')->withTrashed()->withTimestamps();
    }


        
    /**
     * getPanelInfo Retorna las reservas del dia y los estados actuales
     *
     * @return mixed
     */
    protected static function getPanelInfo()
    {   
        $today = date('Y-m-d', time());
        $panelInfo = [
            'confirmed' =>[],
            'initiated' =>[],
            'postponed' =>[],
            'cancelled' =>[],
            'completed' =>[],
        ];
        $reservations = Reservation::where(function ($q){
            $q->where('travel_date',date('Y-m-d', time()))
              ->orWhere('travel_date','<',date('Y-m-d', time()))
              ->where('reservation_status',2)
              ->orWhere('travel_date','<',date('Y-m-d', time()))
              ->where('reservation_status',3)
              ->orWhere('travel_date','<',date('Y-m-d', time()))
              ->where('reservation_status',4)
              ->whereBetween('updated_at',[date('Y-m-d 00:00:00', time()),date('Y-m-d 23:59:59', time())])
              ->orWhere('travel_date','>',date('Y-m-d', time()))
              ->where('reservation_status',4)
              ->whereBetween('updated_at',[date('Y-m-d 00:00:00', time()),date('Y-m-d 23:59:59', time())]);
        })->get();

        if($reservations){
            foreach ($reservations as $reservation) {
                if($reservation->travel_date == $today)
                {
                    if($reservation->reservation_status == 1){
                        array_push($panelInfo['confirmed'], $reservation);
                    }
                    if($reservation->reservation_status == 2){
                        array_push($panelInfo['initiated'], $reservation);
                    }
                    if($reservation->reservation_status == 3){
                        array_push($panelInfo['postponed'], $reservation);
                    }
                    if($reservation->reservation_status == 4){
                        array_push($panelInfo['cancelled'], $reservation);
                    }
                    if($reservation->reservation_status == 5){
                        array_push($panelInfo['completed'], $reservation);
                    }
                }
                if($reservation->travel_date < $today && $reservation->reservation_status == 2)
                {
                    if($reservation->reservation_status == 2){
                        array_push($panelInfo['initiated'], $reservation);
                    }
                }

                if($reservation->travel_date < $today)
                {
                    if($reservation->reservation_status == 3){
                        array_push($panelInfo['postponed'], $reservation);
                    }
                    
                    if($reservation->reservation_status == 4)
                    {
                        array_push($panelInfo['cancelled'], $reservation);
                    }
                }

                if($reservation->travel_date > $today)
                {
                    if($reservation->reservation_status == 4)
                    {
                        array_push($panelInfo['cancelled'], $reservation);
                    }
                }
                
            }

            return $panelInfo;
        }

        return null;
        
    }
    
    /**
     * getConfirmed Retorna las reservas confirmadas
     *
     * @return array Reservation
     */
    protected static function getConfirmed()
    {   
        return self::where('travel_date',date('Y-m-d',time()))
                    ->where('reservation_status',1)
                    ->with('status')
                    ->orderBy('travel_time')
                    ->get();
    }
    
    /**
     * getInitiated Retorna las reservas iniciadas
     *
     * @return array Reservation
     */
    protected static function getInitiated()
    {        
        return self::where('travel_date',date('Y-m-d', time()))
                    ->where('reservation_status',2)
                    ->where('reservation_status',2)
                    ->orWhere('travel_date','<',date('Y-m-d', time()))
                    ->where('reservation_status',2)
                    ->with('status')
                    ->orderBy('travel_date')
                    ->orderBy('travel_time')
                    ->get();
    }

    /**
     * getInitiated Retorna las reservas pospuestas
     *
     * @return array 
     */
    protected static function getPostponed()
    {
        return self::where('travel_date','<',date('Y-m-d', time()))
                    ->where('reservation_status',3)
                    ->with('status')
                    ->orderBy('travel_date')
                    ->orderBy('travel_time')
                    ->get();
    }

    /**
     * getInitiated Retorna las reservas canceladas
     *
     * @return object Reservation
     */
    protected static function getCancelled()
    {
        return self::where('travel_date',date('Y-m-d', time()))
                    ->where('reservation_status',4)
                    ->orWhere('travel_date','<',date('Y-m-d', time()))
                    ->whereBetween('updated_at',[date('Y-m-d 00:00:00', time()),date('Y-m-d 23:59:59', time())] )
                    ->where('reservation_status',4)
                    ->orWhere('travel_date','>',date('Y-m-d', time()))
                    ->whereBetween('updated_at',[date('Y-m-d 00:00:00', time()),date('Y-m-d 23:59:59', time())] )
                    ->where('reservation_status',4)
                    ->with('status')
                    ->orderBy('travel_date')
                    ->orderBy('travel_time')
                    ->get();
    }

    /**
     * getInitiated Retorna las reservas completadas
     *
     * @return object Reservation
     */
    protected static function getCompleted()
    {
        return self::where('travel_date',date('Y-m-d', time()))
                    ->where('reservation_status',5)
                    ->with('status')
                    ->orderBy('travel_date')
                    ->orderBy('travel_time')
                    ->get();
    }

        
    /**
     * getTime Retorna horario del viaje
     *
     * @param  object $reservation
     * @return string 
     */
    protected static function getTime(Reservation $reservation)
    {
        return date('H:i',strtotime($reservation->travel_time));
    }
        
    /**
     * getDate Retoran fecha del viaje
     *
     * @param  object $reservation
     * @return string
     */
    protected static function getDate(Reservation $reservation)
    {
        return date('d-m-Y',strtotime($reservation->travel_date));
    }
    
    /**
     * getCreationDate Retorna la fecha de confirmación de la reserva
     *
     * @param  mixed $reservation
     * @return void
     */
    protected static function getCreationDate(Reservation $reservation)
    {
        return date('d-m-Y H:i',strtotime($reservation->created_at));
    
    }    

    /**
     * getUpdatedDate Retorna la fecha de actualización de la reserva
     *
     * @param  mixed $reservation
     * @return void
     */
    protected static function getUpdatedDate(Reservation $reservation)
    {
        return date('d-m-Y H:i',strtotime($reservation->updated_at));
    }
    
    /**
     * preventBookingPast Previene que se realicen reservas en una fecha menor a la actual
     *
     * @param  mixed $reservation_date
     * @return bool
     */
    protected static function preventBookingPast($reservation_date)
    {   
        $now = date('Y-m-d H:i:s');
        return ($reservation_date < $now) ? false : true;
    }
    
    /**
     * dateCheckToStart Verifica que la fecha de inicio de la reserva sea igual a la fecha actual
     *
     * @param  mixed $reservation
     * @return bool
     */
    protected static function dateCheckToStart(Reservation $reservation)
    {   
        $today = date('Y-m-d', time());
        return ($reservation->travel_date == $today)? true:false;
    }
    
    /**
     * preventEdit Previene que se pueda editar la reserva dependiendo el estado.
     *
     * @param  mixed $reservation
     * @return bool
     */
    protected static function preventEdit(Reservation $reservation)
    {
        switch ($reservation->reservation_status) {
            case 2:
            case 4:
            case 5:
                return true;
                break;
            
            default:
                return false;
                break;
        }
        
    }
    
    /**
     * getTodaysReservations Retorna las reservas del día
     *
     * @return array 
     */
    protected static function getTodaysReservations()
    {
        $today = date('Y-m-d', time());
        $reservations = self::with('status')
        ->where('reservation_status','!=', 4)
        ->where('reservation_status','!=', 5)
        ->where('travel_date','=', $today)
        ->orderBy('travel_time','ASC')
        ->get();
        return $reservations;
    }

    /**
     * getTodaysReservations Retorna las reservas del día que se encuentra canceladas
     *
     * @return array 
     */
    protected static function getTodaysCancellations()
    {   
        $today = date('Y-m-d', time());
        $reservations = self::with('status')
        ->where('reservation_status','=', 4)
        ->where('travel_date','=', $today)
        ->orderBy('travel_time','ASC')
        ->get();
        return $reservations;

    }

     /**
     * getTodaysReservations Retorna las reservas del día que se encuentra pospuestas
     *
     * @return array 
     */
    protected static function getPendingReservations()
    {
        $yesterday = date('Y-m-d',strtotime("-1 days"));
        $reservations = self::with('status')
        ->where('reservation_status','!=',4)
        ->where('reservation_status','!=',5)
        ->where('travel_date','<=',"$yesterday")
        ->where('travel_time','<=',"23:59:59")
        ->with('status')
        ->orderBy('updated_at','ASC')
        ->get();
        return $reservations; 
    }

     /**
     * getTodaysReservations Retorna las reservas del día que se encuentra completadas
     *
     * @return array 
     */
    protected static function getTodaysFinishedReservations()
    {
        $today = date('Y-m-d', time());
        $reservations = self::with('status')
        ->where('reservation_status','=',5)
        ->orderBy('updated_at','ASC')
        ->get();
        return $reservations;
    }
    
    /**
     * getCurrentDriver Retorna los choferes asignados a la reserva
     *
     * @param  object $reservation
     * @return array
     */
    public static function getCurrentDriver(Reservation $reservation)
    {
        $drivers = [];
        foreach($reservation->driver as $d)
        {
            $drivers[]=$d;
        }
        return $drivers;
    }

    
    /**
     * removeDriver Quita al chofer de la reserva
     *
     * @param  object $reservation
     * @return void
     */
    public function removeDriver(Reservation $reservation)
    {
        $reservation->driver()->sync([]);
    }
    
    /**
     * assignDrivers Asigna los choferes a la reserva
     *
     * @param  object $reservation
     * @param  mixed $request
     * @return void
     */
    public static function assignDrivers(Reservation $reservation, $request)
    {
        $drivers = Driver::whereIn('id',$request->input('driver'))->get();
        $reservation->driver()->sync($drivers);
    }
    
    /**
     * assignDriver Asigna chofer a la reserva
     *
     * @param  object $reservation
     * @param  mixed $request
     * @return void
     */
    public static function assignDriver(Reservation $reservation, $request)
    {
        $driver = Driver::findOrFail($request->input('driver'));
        $reservation->driver()->sync($driver->id);
    }
    
    /**
     * removeClient Quita al cliente de la reserva
     *
     * @param  object $reservation
     * @return void
     */
    public function removeClient(Reservation $reservation)
    {
        $reservation->client()->detach($reservation->client[0]->id);  
    }

    
    
    /**
     * confirm Cambia el estado de reserva
     *
     * @return void
     */
    public function confirm()
    {
        $this->reservation_status = 1;
        $this->save();
    }

    /**
     * confirm Cambia el estado de reserva
     *
     * @return void
     */
    public function start()
    {
        $this->reservation_status = 2;
        $this->save();
    }

    /**
     * confirm Cambia el estado de reserva
     *
     * @return void
     */
    public function restart()
    {
        $this->reservation_status = 2;
        $this->save();
    }

    /**
     * confirm Cambia el estado de reserva
     *
     * @return void
     */
    public function rollbackToStart()
    {
        $this->reservation_status = 1;
        $this->save();
    }
    
    /**
     * confirm Cambia el estado de reserva
     *
     * @return void
     */
    public function cancel()
    {
        $this->reservation_status = 4;
        $this->update();
        $log = $this->fresh('client','status','cancellation');
        $this->saveLog($log);
        
    }
    
    /**
     * confirm Cambia el estado de reserva
     *
     * @return void
     */
    public function end()
    {
        $this->reservation_status = 5;
        $this->update();
        $log = $this->fresh('client','status','driver.vehicle.brand','driver.vehicle.color');
        $this->saveLog($log);
    }
    
    /**
     * saveLog
     *
     * @param  mixed $log
     * @return void
     */
    private function saveLog($log)
    {
        try {
            ReservationLog::create([
                'confirmation_number'=>$log->confirmation_number,
                'data'               =>json_encode($log),
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }
    
    /**
     * getDriverIncome Obtiene los ingresos del chofer
     *
     * @return void
     */
    public function getDriverIncome()
    {
        $commission = $this->price *  $this->commission_percentage /100;
        $driver_income = ($this->price - $commission) / $this->vehicle_quantity;
        return $driver_income;
    }

    /**
     * getDriverIncome Obtiene los ingresos del los choferes
     *
     * @return void
     */
    public function getDriversIncome()
    {
        $commission = $this->price *  $this->commission_percentage /100;
        return  $this->price - $commission;
    }

    /**
     * getDriverIncome Obtiene los ingresos de la remisería
     *
     * @return void
     */
    public function getHouseIncome()
    {
        return $this->price - $this->getDriversIncome();
    }



}
