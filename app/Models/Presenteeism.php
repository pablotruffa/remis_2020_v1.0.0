<?php

namespace App\Models;

use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

/**
 * App\Models\Presenteeism
 *
 * @property int $id
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Presenteeism whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Presenteeism extends Model
{   
    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = 'presenteeism';

    /**
     * @var array campo de asignación masiva permitida.
     */
    public static $rules =[
        'driver' => 'array',
        'driver.*' => array(
                            'numeric',
                            'integer',
                            'regex:/^[1-9]+\d*/'
                        ),
    ];

    /**
     * getAttendance Retorna la asistencia de los choferes
     *
     * @return array
     */
    protected static function getAttendance()
    {
        $attendance = ['present'=>[], 'absent'=>[]];
        $drivers = Driver::whereHas('vehicle')->get();
        foreach($drivers as $driver)
        {
            if($driver->presenteeism == 1){
                array_push($attendance['present'],$driver->id); 
            }else{
                array_push($attendance['absent'],$driver->id); 
            }
        
        }
        return $attendance;

    }
    
    /**
     * Función que registra el presentismo.
     *
     * @param  mixed $request
     * @return bool
     */
    protected static function register(Request $request)
    {   

        $data = $request->input();
        if(!isset($data['driver']))
        {
            DB::table('drivers')->update([
                'presenteeism'  =>2,
            ]);
            return true;
            
        }else{
            $drivers = Driver::whereIn('id',$request->input('driver'))
            ->where('assigned_vehicle','!=',null)
            ->get();

            if( count($drivers) == count($request->input('driver')) )
            {   
                $ids =  implode(',',$request->input('driver'));
                DB::update("UPDATE drivers SET presenteeism = CASE WHEN FIND_IN_SET(id , :ids) THEN 1 ELSE 2 END ",['ids' => $ids]); 
                return true;
            }
            return false;
        }
        return false;    
    }
    
    /**
     * verifyActiveReservations Verifica si el chofer se encuentra en una reserva activa.
     *
     * @param  mixed $drivers
     * @return array
     */
    public static function verifyActiveReservations($drivers)
    {   
        $active = [];

        foreach($drivers as $driver)
        {
            foreach($driver->reservation as $reservation)
            {
                if($reservation->reservation_status == 2)
                {
                    if(!in_array($driver->id, $active))
                    {
                        $active[]=$driver->id;
                    }
                }
            }
        }
        return $active;
    }

}
