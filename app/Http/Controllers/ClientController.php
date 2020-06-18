<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Client;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {   
        $clients = Client::all();
        return view('clients.clientList',compact('clients'));
    }


    public function formNew()
    {
        return view('clients.newClient');
    }

    public function create(Request $request)
    {
        $data = $request->input();
        $request->validate(Client::$rules, Client::$messages);
        
        if($request->picture)
        {
            $image = $request->picture;
            $imageName = time().".".$image->extension();
            $image->move(public_path('/client_profile_pictures'), $imageName);

            $data['picture'] = $imageName;
        } else{
            $data['picture'] = null;
        }

        Client::create($data);

        return redirect()
        ->route('clients.index')
        ->with('success','El cliente se insertó exitosamente');
        
    }

    public function info(Request $request, $id)
    {   
        $client = Client::withTrashed()->findOrFail($id);
        $dt = Carbon::parse($client->date_of_birth);
        return view('clients.clientInfo',compact('client','dt'));
    }

    public function getClientByPassport(Request $request)
    {   
        $request->validate([
            'passport'  =>'required|string'
        ]);
        $passport = $request->input('passport');
        $client = Client::withTrashed()->where('identification_card_number', $passport)->first();
        
        if($client)
        {   
            $dt = Carbon::parse($client->date_of_birth);
            return view('clients.clientInfo',compact('client','dt'));
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
        $client = Client::findOrFail($id);
        return view('clients.editClient',compact('client'));
    }

    public function edit(Request $request, $id)
    {
        
        $db_client = Client::findOrFail($id);
        $data = $request->input();
        $request->validate(Client::edit_rules($db_client->id), Client::$messages);

        
        if($db_client->picture)
        {  
           if($request->picture)
           {
                $image = $request->picture;
                $imageName = time().".".$image->extension();
                $image->move(public_path('/client_profile_pictures'), $imageName);

                try {
                    unlink(public_path('/client_profile_pictures/'.$db_client->picture));
                } catch (\Throwable $th) {
                    
                }
                

                $data['picture'] = $imageName;
           }else{
               $data['picture'] = $db_client->picture;
           }
        }else{

            if($request->picture)
            {
                $image = $request->picture;
                $imageName = time().".".$image->extension();
                $image->move(public_path('/client_profile_pictures'), $imageName); 
                $data['picture'] = $imageName;  
            }else{
               $data['picture'] = null;
            }
        }

        $db_client->update($data);
        $message = [
            'class'=>'success',
            'title'=>'Acción completada!',
            'content'=>"El cliente fue editado exitosamente.",
        ];
        return redirect("client/$db_client->id/info")
        ->with('message',$message);

    }

    public function delete($id)
    {
        $client = Client::findOrFail($id);
        if(Client::isInAInitiatedReservation($client->id)){
            $message = [
                'class'=>'danger',
                'title'=>'Acción denegada!',
                'content'=>"El cliente se encuentra en una reserva iniciada.",
            ];
            return redirect()->back()
            ->with('message',$message);
        }
        if($client->picture)
        {   
            try {
                unlink(public_path('/client_profile_pictures/'.$client->picture));
                $client->picture = null;
            } catch (\Throwable $th) {
                
            }
           
        }

        #Delete confirmed & postponed reservations -----------------------------
        $reservations = Reservation::whereHas('client', function($q) use ($client){
            $q->where('clients.id',$client->id);
        })->get();  

        foreach($reservations as $reservation){
            $reservation->cancellation()->attach(4);
            $reservation->cancel();
        }

        #------------------------------------------------------------

        $c = $client->first_name." ".$client->last_name;
        $client->save();
        $client->delete();

        $message = [
            'class'=>'success',
            'title'=>'Acción completada!',
            'content'=>"El cliente fue eliminado.",
        ];

        return redirect()
        ->route('clients.index')
        ->with('message',$message);

    }

    public function restore($id)
    {   
        $client = Client::withTrashed()->findOrFail($id);
        $client->restore();
        $message = [
            'class'=>'success',
            'title'=>'Acción completada!',
            'content'=>"El cliente fue restablecido.",
        ];
        return redirect()->route('clients.index')->with('message',$message);
    }

}
