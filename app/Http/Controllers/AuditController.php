<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{    
    public function index()
    {
        $audit  = new Audit();
        $dates = [
            'from'  =>$audit->getFrom(),
            'to'    =>$audit->getTo(),
        ];
        return view('audit.globalAudit',compact('audit','dates'));
    }

    public function getAuditDate(Request $request)
    {
        $request->validate([
            'from'  =>'required|date_format:Y-m-d',
            'to'  =>'required|date_format:Y-m-d',
        ]);
        
        $from = $request->input('from');
        $to   = $request->input('to');
        $today = date('Y-m-d',time());
        if($from > $today || $to > $today){
            $message = [
                'class'         =>'danger',
                'title'         =>'Error!',
                'content'       =>"Las fechas ingresadas superan la fecha actual!",
            ];
            return redirect()->back()->with('message',$message)->withInput();
        }
        if($from > $to){
            $message = [
                'class'         =>'danger',
                'title'         =>'Error!',
                'content'       =>"'Desde' supera 'Hasta'",
            ];
            return redirect()->back()->with('message',$message)->withInput();
        }
        $dates = [
            'from'=>$from,
            'to'=>$to
        ];
        $audit = new Audit($dates);
        return view('audit.globalAudit',compact('audit','dates'));
    }
    

}
