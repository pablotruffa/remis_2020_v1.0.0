<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationLog;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ReservationController extends Controller
{  
    public function all()
    {
        $reservations = Reservation::all();
        return response()->json($reservations);
    }

    public function byId($id)
    {
        $reservation = Reservation::find($id);
        return response()->json($reservation);
    }

    public function completed()
    {
        $reservations = Reservation::where('reservation_status',5)->get('confirmation_number');
        $logs = ReservationLog::whereIn('confirmation_number',$reservations)->get();
        foreach($logs as $log)
        {
            $log->data = json_decode($log->data);
        }
        return $logs;

    }

    public function cancelled()
    {
        $reservations = Reservation::where('reservation_status',4)->get('confirmation_number');
        $logs = ReservationLog::whereIn('confirmation_number',$reservations)->get();
        foreach($logs as $log)
        {
            $log->data = json_decode($log->data);
        }
        return $logs;
    }

    public function postponed()
    {
        $reservations = Reservation::where('reservation_status',3)->get();
        return response()->json($reservations);
    }
    
    public function initiated()
    {
        $reservations = Reservation::where('reservation_status',2)->get();
        return response()->json($reservations);
    }

    public function confirmed()
    {   
        $reservations = Reservation::where('reservation_status',1)->get();
        return response()->json($reservations);
    }

    public function store(Request $request)
    {    
       
        $request->validate(Reservation::$rules);

        if($request->json('travel_date') < date('Y-m-d',time()))
        {
            return response()->json([
                'created' => false,
                'message' => 'Cannot create a reservation with a past date' 
            ]);
        }
        
        $reservation = Reservation::create($request->json()->all());
        return response()->json([
    		'created' => true,
    		'data' => $reservation
		]);

    }

    public function edit(Request $request,$id)
    {   
        $request->validate([
            'travel_date'           =>'required|date_format:Y-m-d',
            'travel_time'           =>'required|date_format:H:i',
            'origin'                =>'required|string|min:2|max:300',
            'destiny'               =>'required|string|min:2|max:300',
            'vehicle_quantity'      =>'required|numeric|integer|between:1,10',
            'price'                 =>'required|numeric|between:0,500000.00',
            'commission_percentage' =>'required|numeric|between:0,100',
        ]);
        
        $db_reservation = Reservation::find($id);

        $data = $request->json()->all();
        
        $db_reservation->update($data);

        return response()->json([
            'updated'   => true,
            'data'      =>$db_reservation,
        ]);

    }

    public function cancel($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->reservation_status = 4;
        $reservation->update();
        

        return response()->json([
            'cancelled' => true,
            'data'      =>$reservation,
        ]);
    }


}
