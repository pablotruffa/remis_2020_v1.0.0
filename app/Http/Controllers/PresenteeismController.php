<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Presenteeism;
use Illuminate\Http\Request;

class PresenteeismController extends Controller
{
    public function index()
    {   
        $available_drivers = Driver::whereHas('vehicle')->get();
        $active = Presenteeism::verifyActiveReservations($available_drivers);
        if($available_drivers->count() == 0){
            $message = [
                'class'     =>'warning',
                'title'     =>'Atencion!',
                'content'   =>'Para poder dar el presentismo es necesario que hayan chofers con asignado vehículo asignado.',
                'route'     =>['link'=>'drivers.index', 'name'=>'Choferes'],      
            ];
            return redirect()
            ->route('reservations.index')
            ->with('message',$message);
        }else{
            return view('drivers.driverPresenteeism', compact('available_drivers','active'));
        }
    }

    public function attendance(Request $request)
    {   
        $request->validate(Presenteeism::$rules);
        if(Presenteeism::register($request))
        {   $attendance = Presenteeism::getAttendance();
            $present = count($attendance['present']);
            $absent  = count($attendance['absent']);
            
            $message = [
                'class'     =>'success',
                'title'     =>'Actualizado!',
                'content'   =>"Chofers presentes: ($present), choferes ausentes: ($absent)",      
            ];
        }else{

            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   =>"No se logró actualizar la lista de presentismo.",      
            ];
        }
        return redirect()->back()->with('message',$message);
    
    }

}
