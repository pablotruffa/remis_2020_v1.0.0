<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\DriverBalance;

class BalanceController extends Controller
{
    public function wallet()
    {
        $balance = new DriverBalance();
        return view('drivers.wallet', compact('balance'));
    }

    public function trips()
    {   
        $balance        = new DriverBalance();
        $userCreation   = $balance->getUser()->created_at; 
        $from           = $userCreation;
        $to             = date('Y-m-d',time()); 
        return view('drivers.trips', compact('balance','userCreation','from','to'));
    }

    public function tripsByDate(Request $request)
    {
        $this->dateValidation($request);
        $from   = $request->input('from');
        $to     = $request->input('to');

        $balance = new DriverBalance();
        $balance->setReservationsDate($from,$to);
        $userCreation = $balance->getUser()->created_at;
        
        return view('drivers.trips', compact('balance','userCreation','from','to'));

    }

    public function pdfTrips(Request $request)
    {
        $this->dateValidation($request);
        $from   = $request->input('from');
        $to     = $request->input('to');
        $balance = new DriverBalance();
        $balance->setReservationsDate($from,$to);
        $userCreation = $balance->getUser()->created_at;
        $user = $balance->getUser();
        $pdf = PDF::loadView('drivers.tripsToPdf', compact('balance','from','to','user'))->setPaper('a4', 'landscape');
        return $pdf->download('viajes.pdf');
    }


    public function dateValidation($request)
    {
        $request->validate([
            'from'  =>'required|date_format:Y-m-d',
            'to'    =>'required|date_format:Y-m-d',
        ]);

        $from   = $request->input('from');
        $to     = $request->input('to');
        $today  = date('Y-m-d',time());

        if($from > $today || $to > $today){
            $message = [
                'class'         =>'danger',
                'title'         =>'Error!',
                'content'       =>"Las fechas ingresadas superan la fecha actual!",
            ];
            return redirect()->route('trips')->with('message',$message)->withInput();
        }

        if($from > $to){
            $message = [
                'class'         =>'danger',
                'title'         =>'Error!',
                'content'       =>"'Desde' supera 'Hasta'",
            ];
            return redirect()->route('trips')->with('message',$message)->withInput();
        }
    }
}
