<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\RemisUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    public function index()
    {   
        $drivers = Driver::all();
        return view('drivers.driverList',compact('drivers'));
    }

    public function formNew()
    {   
        return view('drivers.newDriver');
    }


    public function create(Request $request)
    {
        $data = $request->input();
        $request->validate(Driver::$rules, Driver::$messages);
        
        if($request->picture)
        {
            $image = $request->picture;
            $imageName = time().".".$image->extension();
            $image->move(public_path('/driver_profile_pictures'), $imageName);

            $data['picture'] = $imageName;
        } else{
            $data['picture'] = null;
        }
        $data['presenteeism'] = 2;
        Driver::create($data);

        #CreateRemisUserWithDriverData
        try {
            RemisUsers::create([
                'email'     =>$data['email'],
                'password'  =>Hash::make($data['car_license']),
                'level_id'  =>'2',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        

        #-----------------------------
        $message = [
            'class'=>'info',
            'title'=>'Sin resultados!',
            'content'=>"El chofer se insertó exitosamente.",
        ];
        return redirect()
        ->route('drivers.index')
        ->with('message',$message);
        
    }

    public function info(Request $request, $id)
    {  
        $driver = Driver::withTrashed()->findOrFail($id);
        $dt = Carbon::parse($driver->date_of_birth);
        return view('drivers.driverInfo',compact('driver','dt'));
    }

    public function profile()
    {   
        $user = Auth::user();
        $driver = Driver::withTrashed()
        ->where('email',$user->email)
        ->first();
        $dt = Carbon::parse($driver->date_of_birth);
        return view('drivers.profile',compact('driver','dt'));
    }

    public function getDriverByPassport(Request $request)
    {   
        $request->validate([
            'passport'  =>'required|string'
        ]);
        $passport = $request->input('passport');
        $driver = Driver::withTrashed()->where('identification_card_number', $passport)->first();
        if($driver)
        {   
            $dt = Carbon::parse($driver->date_of_birth);
            return view('drivers.driverInfo',compact('driver','dt'));
        }

        $message = [
            'class'=>'info',
            'title'=>'Sin resultados!',
            'content'=>"No se econtraron datos.",
        ];
        return redirect()->back()->with('message',$message);

    }

    public function formEdit($id)
    {
        $driver = Driver::findOrFail($id);
        return view('drivers.editDriver',compact('driver'));
    }

    public function edit(Request $request, $id)
    {
        
        $db_driver = Driver::findOrFail($id);
        $data = $request->input();
        $request->validate(Driver::edit_rules($db_driver->id), Driver::$messages);

        
        if($db_driver->picture)
        {  
           if($request->picture)
           {
                $image = $request->picture;
                $imageName = time().".".$image->extension();
                $image->move(public_path('/client_profile_pictures'), $imageName);

                try {
                    unlink(public_path('/client_profile_pictures/'.$db_driver->picture));
                } catch (\Throwable $th) {
                    
                }
                

                $data['picture'] = $imageName;
           }else{
               $data['picture'] = $db_driver->picture;
           }
        }else{

            if($request->picture)
            {
                $image = $request->picture;
                $imageName = time().".".$image->extension();
                $image->move(public_path('/driver_profile_pictures'), $imageName); 
                $data['picture'] = $imageName;  
            }else{
               $data['picture'] = null;
            }
        }

        $db_driver->update($data);

        return redirect("driver/$db_driver->id/info")
        ->with('success','El chofer fue editado exitosamente');

    }

    public function delete($id)
    {
        $driver = Driver::findOrFail($id);
        
        $reservations = Driver::driverHasReservations($driver);
        if(!empty($reservations)){
            $message = [
                'class'         =>'danger',
                'title'         =>'Error!',
                'content'       =>"El chofer $driver->first_name $driver->last_name no puede ser eliminado porque cuenta con (".count($reservations).") reservas activas.",
            ];
            return redirect()
            ->back()
            ->with('message',$message);
        }
        if($driver->picture)
        {   
            try {
                unlink(public_path('/driver_profile_pictures/'.$driver->picture));
                $driver->picture = null;
            } catch (\Throwable $th) {
                
            }
           
        }

        $driver->assigned_vehicle = null;

        $d = $driver->first_name." ".$driver->last_name;
    
        $driver->save();
        $driver->delete();
        $message = [
            'class'=>'success',
            'title'=>'Excelente!',
            'content'=>"El chofer $d fue eliminado exitosamente",
        ];
        return redirect()
        ->route('drivers.index')
        ->with('message',$message);

    }

    public function formAssignVehicle($driver_id)
    {
        /**
         * Get all vehicle without an assigned driver.
         */

        $available_vehicles = Vehicle::whereDoesntHave('driver')
        ->with(['brand','color'])
        ->get();


        if(count($available_vehicles) == 0)
        {   
            $message = [
            'class'=>'danger',
            'title'=>'Error!',
            'content'=>"No hay vehículos disponibles.",
            ];
            return redirect()->back()->with('message',$message);
        }

        $driver = Driver::findOrFail($driver_id);

        return view('drivers.driverAssignVehicle',compact('available_vehicles','driver'));
    }

    public function assignVehicle(Request $request, $driver_id)
    {
       
        $vehicle = Vehicle::findOrFail($request->input('vehicle'));
        $driver = Driver::findOrFail($driver_id);


        $driver->assigned_vehicle = $vehicle->id;
        $driver->update();


        $message = [
            'class'=>'success',
            'title'=>'Excelente!',
            'content'=>"Vehículo asignado exitosamente.",
            ];
        return redirect("driver/{$driver->id}/info")
        ->with('message', $message);
    }

    public function unassignVehicle($driver_id)
    {
        $driver = Driver::findOrFail($driver_id);
        if(Vehicle::isInAInitiatedReservation($driver->assigned_vehicle)){
            $message = [
                'class'=>'danger',
                'title'=>'Acción denegada!',
                'content'=>"El vehículo se encuentra en una reserva iniciada",
            ];
            return redirect()->back()->with('message',$message);
        }

        $driver->assigned_vehicle = null;
        $driver->update();
        $message = [
            'class'=>'success',
            'title'=>'Acción completada!',
            'content'=>"El vehículo fue desasignado exitosamente",
        ];
        
        return redirect("driver/{$driver->id}/info")
        ->with('message',$message);
    }


    public function restore($id)
    {   
        $driver = Driver::withTrashed()->findOrFail($id);
        $driver->restore();
        $message = [
            'class'=>'success',
            'title'=>'Acción completada!',
            'content'=>"El chofer fue restablecido.",
        ];
        return redirect()->back()->with('message',$message);
    }

}
