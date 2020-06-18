<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\CarBrand;
use App\Models\CarColor;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with(['brand','color'])->get();
        return view('vehicles.vehicleList',compact('vehicles'));
    }

    public function formNew()
    {
        $brands = CarBrand::all();
        $colors = CarColor::all();
        return view('vehicles.newVehicle', compact('brands','colors'));
    }

    public function create(Request $request)
    {
        $data = $request->input();
        //dd($data);
        $request->validate(Vehicle::$rules,Vehicle::$messages);
        
        if($request->picture)
        {
            $image = $request->picture;
            $imageName = time().".".$image->extension();
            $image->move(public_path('/vehicle_pictures'), $imageName);

            $data['picture'] = $imageName;
        } else{
            $data['picture'] = null;
        }
        $data['patent'] = strtoupper($data['patent']);
        Vehicle::create($data);

        $message = [
            'class'     =>'success',
            'title'     =>'Acción completada!',
            'content'   =>"El vehículo se insertó exitosamente.",
        ];

        return redirect()
        ->route('vehicles.index')
        ->with('message',$message);
    
    }

    public function info($id)
    {
        $vehicle = Vehicle::with(['brand','color','driver'])->findOrFail($id);
        return view('vehicles.vehicleInfo', compact('vehicle'));
    }

    public function formEdit($id)
    {   
        $brands = carBrand::all();
        $colors = carColor::all();
        $vehicle = Vehicle::with(['brand','color'])->findOrFail($id);

        return view('vehicles.editVehicle', compact('vehicle', 'colors', 'brands'));
    }

    public function edit(Request $request, $id)
    {   
        $data = $request->input();
    
        $db_vehicle = Vehicle::findOrFail($id);
        $request->validate(Vehicle::edit_rules($db_vehicle->id), Vehicle::$messages);
        
        if($db_vehicle->picture)
        {  
           if($request->picture)
           {
                $image = $request->picture;
                $imageName = time().".".$image->extension();
                $image->move(public_path('/vehicle_pictures'), $imageName);

                try {
                    unlink(public_path('/vehicle_pictures/'.$db_vehicle->picture));
                } catch (\Throwable $th) {
                    
                }
                

                $data['picture'] = $imageName;
           }else{
               $data['picture'] = $db_vehicle->picture;
           }
        }else{

            if($request->picture)
            {
                $image = $request->picture;
                $imageName = time().".".$image->extension();
                $image->move(public_path('/vehicle_pictures'), $imageName); 
                $data['picture'] = $imageName;  
            }else{
               $data['picture'] = null;
            }
        }

        $db_vehicle->update($data);

        $message = [
            'class'     =>'success',
            'title'     =>'Acción completada!',
            'content'   =>"El vehiculo fue editado exitosamente.",
        ];


        return redirect("vehicle/$db_vehicle->id/info")
        ->with('message',$message);
    }


    public function delete($id)
    {
        $vehicle = Vehicle::with('driver')->findOrFail($id);
        
        if(Vehicle::isInAInitiatedReservation($vehicle->id))
        {
            $message = [
                'class'     =>'danger',
                'title'     =>'Acción denegada!',
                'content'   =>"No se puede eliminar el vehículo porque se encuentra en una reserva iniciada.",
            ];
            return redirect()->back()->with('message',$message);
        }
        if(!is_null($vehicle->driver)){
            
            $driver = Driver::findOrFail($vehicle->driver->id);
            $driver->assigned_vehicle = null;
            $driver->update();
        }
        
        if($vehicle->picture)
        {
            try {
                unlink(public_path('/vehicle_pictures/'.$vehicle->picture));
            } catch (\Throwable $th) {

            }
        }

        $p = $vehicle->patent;
        $vehicle->delete();

        $message = [
            'class'     =>'success',
            'title'     =>'Acción completada!',
            'content'   =>"El vehículo con patente $p fue eliminado exitosamente.",
        ];

        return redirect()
        ->route('vehicles.index')
        ->with('message',$message);
    }

    public function formAssignDriver($vehicle_id)
    {
        /**
         * Get all drivers without an assigned vehicle.
         */

        $available_drivers = Driver::whereDoesntHave('vehicle')
        ->get();


        if(count($available_drivers) == 0)
        {   
            $message = [
                'class'     =>'success',
                'title'     =>'Acción completada!',
                'content'   =>"No hay choferes disponibles.",
            ];
            return redirect()->back()->with('message',$message);
        }

        $vehicle = Vehicle::findOrFail($vehicle_id);

        return view('vehicles.vehicleAssignDriver',compact('available_drivers','vehicle'));
    }

    public function assignDriver(Request $request, $vehicle_id)
    {
       
        $driver = Driver::findOrFail($request->input('driver'));
        $vehicle = Vehicle::findOrFail($vehicle_id);


        $driver->assigned_vehicle = $vehicle->id;
        $driver->update();

        $message = [
            'class'     =>'success',
            'title'     =>'Acción completada!',
            'content'   =>"Chofer asignado exitosamente.",
        ];
        return redirect("vehicle/{$vehicle->id}/info")
        ->with('message',$message);
    }

    public function unassignDriver($vehicle_id)
    {
        $vehicle = Vehicle::findOrFail($vehicle_id);
        $driver = Driver::findOrFail($vehicle->driver->id);


        $driver->assigned_vehicle = null;
        $driver->update();

        $message = [
            'class'     =>'success',
            'title'     =>'Acción completada!',
            'content'   =>"El chofer fue desasignado exitosamente.",
        ];

        return redirect("vehicle/{$vehicle->id}/info")
        ->with('message', $message);
    }

}
