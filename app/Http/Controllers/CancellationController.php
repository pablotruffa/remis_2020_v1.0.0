<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationLog;
use App\Models\CancellationReason;

class CancellationController extends Controller
{
    public function index()
    {   
        $reasons = CancellationReason::all();
        return view('cancellations.reasonList', compact('reasons'));
    }
    
    public function formCancellation($id)
    {
        $reservation = Reservation::findOrFail($id);
        if(in_array($reservation->reservation_status,[4,5]))
        {   
            $message = [
                'class'     =>'danger',
                'title'     =>'Prohibido.',
                'content'   =>'No se puede cancelar la reserva.',
            ];
            return redirect()->back()
            ->with('message',$message);
        }
        $cancellation_reasons = CancellationReason::all();
        return view('cancellations.cancelReservation',compact('cancellation_reasons','reservation'));
    }

    public function cancelReservation(Request $request, $id)
    {   
        $request->validate(CancellationReason::$cancel_form,CancellationReason::$messages );
        
        $reservation = Reservation::findOrFail($id);
        $reason = CancellationReason::findOrFail($request->input('reason_id'));
    
        $reservation->cancellation()->attach($request->input('reason_id'), ['remark'=>$request->input('remark')]);
        $reservation->cancel();
        
        $message = [
                'class'     =>'success',
                'title'     =>'Cxl!',
                'content'   =>'La reserva fue cancelada.',
            ];
            return redirect()
            ->route('reservations.index')
            ->with('message',$message);
    }

}
