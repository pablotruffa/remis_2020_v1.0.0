<?php

namespace App\Models;

use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\Request;

class Presenteeism extends Model
{
    protected $table = 'presenteeism';

    public static $rules =[
        'driver' => 'array',
        'driver.*' => array(
                            'numeric',
                            'integer',
                            'regex:/^[1-9]+\d*/'
                        ),
    ];

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
