<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Driver;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\ReservationLog;
use Illuminate\Support\Carbon;
use App\Models\ReservationStatus;
use App\Models\CancellationReason;

class ReservationController extends Controller
{
    public function index()
    {   
        $reservations = Reservation::getPanelInfo();
        return view('reservations.reservationPanel',compact('reservations'));
    }

    public function getConfirmed()
    {   
        $h1 ="Reservas confirmadas."; 
        $reservations = Reservation::getConfirmed();
        return view('reservations.reservationList',compact('reservations','h1'));
    }
    
    public function getInitiated()
    {
        $h1 ="Reservas iniciadas."; 
        $reservations = Reservation::getInitiated();
        return view('reservations.reservationList',compact('reservations','h1'));
    }
    
    public function getPostponed()
    {
        $h1 ="Reservas postergadas."; 
        $reservations = Reservation::getPostponed();
        return view('reservations.reservationList',compact('reservations','h1'));
    }
    
    public function getCancelled()
    {
        $h1 ="Reservas canceladas."; 
        $reservations = Reservation::getCancelled();
        return view('reservations.reservationList',compact('reservations','h1'));
    }
    
    public function getCompleted()
    {
        $h1 ="Reservas concretadas."; 
        $reservations = Reservation::getCompleted();
        return view('reservations.reservationList',compact('reservations','h1'));
    }


    

    protected function switchStatus($reservation_id, $status)
    {
        $reservation = Reservation::findOrFail($reservation_id);
        $reservation->reservation_status = $status;
        $reservation->update();
    }

    public function reservationByDate(Request $request)
    {   
        $date = $request->input('date');
        $request->validate([
            'date'  =>'required|date',
        ]);
        
        $reservations = Reservation::with('status')
        ->where('travel_date','=',$date)
        ->orderBy('travel_time', 'ASC')
        ->get();
        if($reservations->count() == 0)
        {
            $message = [
                'class'     =>'danger',
                'title'     =>'Sin resultados!',
                'content'   =>"No se encontraron reservas para la fecha $date.",
            ];
            return redirect()->back()->with('message',$message);
        }

        foreach ($reservations as $re) {

            $re->travel_date = Reservation::getDate($re);
            $re->travel_time = Reservation::getTime($re);
        }
        $h1 = "Reservas del $date.";
        return view('reservations.reservationList',compact('reservations','h1'));
    }

    public function searchConfirmation(Request $request)
    {   
        $request->validate([
            'confirmation_number' =>'integer|min:0'
        ]);
        
        $reservation = Reservation::where('confirmation_number', $request->input('confirmation_number'))
        ->with('log')
        ->first();

        if($reservation){
            if($reservation->log){
                $log = json_decode($reservation->log->data);
                return view('reservations.reservationInfo',compact('log'));
            }else{
                $client = $reservation->client[0]->first_name." ".$reservation->client[0]->last_name;
        
                $date = Reservation::getDate($reservation);
                $time = Reservation::getTime($reservation);

                $created   = Reservation::getCreationDate($reservation);
                $updated   = Reservation::getUpdatedDate($reservation);
                return view('reservations.reservationInfo',compact('reservation','client','date','time','created','updated'));
            }
        }
        $message = [
            'class'     =>'danger',
            'title'     =>'Sin resultados!',
            'content'   =>'No se encontraron datos.',
        ];
        return redirect()->back()->with('message',$message);

        

    }

    public function info($id)
    {   
        
        $reservation = Reservation::with(['status','client','driver'])->findOrFail($id);
        
        $reservationLog = ReservationLog::where('confirmation_number',$reservation->confirmation_number)->first();
    
        if($reservationLog){
            $log = json_decode($reservationLog->data);
            return view('reservations.reservationInfo',compact('log'));
        }
        
        
        $client = $reservation->client[0]->first_name." ".$reservation->client[0]->last_name;
        
        $date = Reservation::getDate($reservation);
        $time = Reservation::getTime($reservation);

        $created   = Reservation::getCreationDate($reservation);
        $updated    = Reservation::getUpdatedDate($reservation);
        
        return view('reservations.reservationInfo',compact('reservation','client','date','time','created','updated'));
    }


    public function formNew($id = null)
    {   
        
        $clients = Client::all();
        if($clients->count() == 0 ){
    
            $message = [
                'class'     =>'danger',
                'title'     =>'Sin clientes!',
                'content'   =>'Al parecer no se encuentran clientes activos. Deberas registrar algún cliente antes de hacer una reserva.',
                'route'     =>[
                                'name'  =>'Nuevo cliente',    
                                'link'  =>'client/new'    
                              ],
            ];
            return redirect()
            ->back()
            ->with('message',$message);
        }
        if($id)
        {   
            $client_selected = Client::findOrFail($id);
            return view('reservations.newReservation', compact('clients','client_selected'));
        }
        return view('reservations.newReservation', compact('clients'));
    }
    
    public function create(Request $request)
    {
        
        $data = $request->input();
        
        $request->validate(Reservation::$rules, Reservation::$messages);
        
        $reservation_date = $data['travel_date'].' '.$data['travel_time'];
        if(!Reservation::preventBookingPast($reservation_date)){
            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   =>'No se puede reservar una fecha pasada.',
            ];
            return redirect()
            ->back()
            ->withInput()
            ->with('message',$message);
        }
        $data['confirmation_number'] = time();
        $data['reservation_status'] = 1;
        $total_amount = $data['price'] * $data['vehicle_quantity'];
        $data['price'] =  $total_amount;
        $reservation = Reservation::create($data);
        
        $reservation->client()->attach($data['id_client']);
        $message = [
            'class'     =>'success',
            'title'     =>'Excelente!',
            'content'   =>'Reserva creada exitosamente.',
        ];
        return redirect()
        ->route('reservations.index')
        ->with('message',$message);
    }

    public function formEdit($id)
    {
        $reservation = Reservation::findOrFail($id);
        if(Reservation::preventEdit($reservation)){
            $status = $reservation->status->status;
            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   =>"No se puede editar la reserva porque se encuentra $status.",
            ];
            return redirect()
            ->back()
            ->with('message',$message);
        }

        $clients = Client::all();
        $reservation->price = $reservation->price / $reservation->vehicle_quantity;

        return view('reservations.editReservation',compact('reservation','clients'));
    }

    public function edit(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $request->validate(Reservation::$rules, Reservation::$messages);
        $data = $request->input();
        $data['travel_time'] = date('H:i:s', strtotime($data['travel_time']));
        if($reservation->travel_date != $data['travel_date'] || $reservation->travel_time != $data['travel_time'] )
        {
            $reservation_date = $data['travel_date'].' '.$data['travel_time'];
            if(!Reservation::preventBookingPast($reservation_date)){
                $message = [
                    'class'     =>'danger',
                    'title'     =>'Error!',
                    'content'   =>'No se permite resevar en fechas pasadas.',
                ];
                return redirect()
                ->back()
                ->with('message',$message)
                ->withInput();
            }
        }
        
        $total_amount = $data['price'] * $data['vehicle_quantity'];
        $data['price'] =  $total_amount;

        $reservation->update($data);
        if($reservation->reservation_status == 3){
            $reservation->confirm();
            $message = [
                'class'     =>'success',
                'title'     =>'Excelente!',
                'content'   =>'Reserva editada exitosamente. Postergada ---> Confirmada',
            ];
        }else{
            $message = [
                'class'     =>'success',
                'title'     =>'Excelente!',
                'content'   =>'Reserva editada exitosamente.',
            ];
        }
        
        return redirect("reservation/$reservation->id/info")->with('message',$message);
    }

    public function rollbackToStart($id)
    {
        $reservation = Reservation::findOrFail($id);
        $today = date('Y-m-d',time());
        if($reservation->travel_date < $today)
        {   
            $message = [
                'class'     =>'danger',
                'title'     =>'Acción denegada!',
                'content'   =>"No se puede cancelar el inicio de una reserva que no se de la fecha actual. La misma puede ser posterga y luego editada con una nueva fecha.",
            ];
            return redirect()->back()->with('message',$message);
        }

        $reservation->removeDriver($reservation);
        $reservation->rollbackToStart();
        $c_n = $reservation->confirmation_number;
        $message = [
                'class'     =>'success',
                'title'     =>'Reserva modificada',
                'content'   =>"La reserva #$c_n se encuentra confirmada.",
            ];
            return redirect()
            ->route('reservations.index')
            ->with('message',$message);
    }

    public function formSwitchDriver($id)
    {   
        $reservation = Reservation::findOrFail($id);
        $available_drivers = Driver::whereHas('vehicle')
        ->where('presenteeism','=',1)
        ->get();
        $selected =[];
        foreach ($reservation->driver as $key => $driver) {
            $selected[]=$driver->id;
        }
       
        if(count($available_drivers) == 0)
        {
            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   =>'No hay choferes con vehículos disponibles para tomar la reserva.',
            ];
            return redirect()->back()->with('message',$message);
        }else if(count($available_drivers) == 1 && $reservation->vehicle_quantity == 1){
            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   =>'No es posible realizar el cambio porque solo hay (1) chofer disponible',
            ];
            return redirect()->back()->with('message',$message);
        }
        return view('reservations.reservationSwitchDriver', compact('reservation','available_drivers','selected'));
    }

    public function switchDriver(Request $request, $id)
    {   
        $reservation = Reservation::findOrFail($id);
        //$reservation->removeDriver($reservation);
        $assignation = $this->assignationStart($reservation, $request);
        if(!$assignation){
            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   =>'La cantidad de choferes seleccionados no cumple la cantidad de vehiculos necesarios para la actual reserva.',
            ];
            return redirect()
            ->back()
            ->withInput()
            ->with('message',$message);
        }else{
            $reservation->restart();
            $message = [
                'class'     =>'info',
                'title'     =>'Excelente!',
                'content'   =>'La reserva se encuentra reiniciada con choferes actualizados',
            ];
            return redirect()
            ->route('reservations.index')
            ->with('message',$message);
        }
    }

    protected function formAssignDriver($reservation_id)
    {   
        
        $reservation = Reservation::whereDoesntHave('driver')->findOrFail($reservation_id);
        if( !Reservation::dateCheckToStart($reservation) )
        {   
            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   =>'No se puede iniciar una reserva fuera de fecha',
            ];
            return redirect()
            ->route('reservations.index')
            ->with('message',$message);
        }
        $available_drivers = Driver::whereHas('vehicle')
        ->where('presenteeism','=',1)
        ->get();
        
        if(count($available_drivers) == 0)
        {
            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   =>'No hay choferes disponibles para tomar la reserva.',
            ];
            return redirect()->back()->with('message',$message);
        }

        return view('reservations.reservationAssignDriver',compact('reservation','available_drivers'));

    }

    protected function startReservation(Request $request, $id)
    {   
        
        $reservation = Reservation::findOrFail($id);
        $assignation = $this->assignationStart($reservation, $request);
        if(!$assignation){
            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   =>'La cantidad de choferes seleccionados no cumple la cantidad de vehiculos necesarios para la actual reserva.',
            ];
            return redirect()
            ->back()
            ->withInput()
            ->with('message',$message);
        }else{
            $reservation->start();
            $message = [
                'class'     =>'success',
                'title'     =>'Excelente!',
                'content'   =>'La reserva se encuentra iniciada.',
            ];
            return redirect()
            ->route('reservations.index')
            ->with('message',$message);
        }
    
    }

    protected function assignationStart(Reservation $reservation, Request $request)
    {
        $assignation = $this->assignDriver($reservation, $request);
        return $assignation;
    }



    protected function endReservation($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->end();
        
        $message = [
            'class'     =>'success',
            'title'     =>'Excelente!',
            'content'   =>'La reserva se encuentra finalizada.',
        ];
        return redirect()
        ->route('reservations.index')
        ->with('message',$message);
    }


    protected function assignDriver(Reservation $reservation, Request $request)
    {
        if($reservation->vehicle_quantity > 1)
        {   
            $request->validate(Reservation::$driver_assign_checkbox_rules, Reservation::$messages );
            if(count($request->input('driver')) != $reservation->vehicle_quantity )
            {
                return false;
            }else{
                Reservation::assignDrivers($reservation, $request); 
                return true;
            }
        }else{
            $request->validate(Reservation::$driver_assign_radio_rules, Reservation::$messages );
            Reservation::assignDriver($reservation, $request);
            return true;
        }
    }
    
}
