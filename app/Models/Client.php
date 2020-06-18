<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{   
    use SoftDeletes;
    protected $table = 'clients';
    protected $hidden = ['pivot'];

    protected $fillable = ['first_name','last_name','email','identification_card_number','date_of_birth','picture'];

    public static $rules = [
        'first_name'                        =>'required|string|min:2|max:150',
        'last_name'                         =>'required|string|min:2|max:150',
        'email'                             =>'required|email|unique:clients,email',
        'identification_card_number'        =>'required|string|min:5|max:25|unique:clients,identification_card_number',
        'date_of_birth'                     =>'required|date',
        'picture'                           =>'image',
        
    ];

    public static function edit_rules($id){
        return [
            'first_name'                    =>'required|string|min:2|max:150',
            'last_name'                     =>'required|string|min:2|max:150',
            'email'                         =>'required|email|unique:clients,email,'.$id,
            'identification_card_number'    =>'required|string|min:5|max:25|unique:clients,identification_card_number,'.$id,
            'date_of_birth'                 =>'required|date',
            'picture'                       =>'image',
        ];
    }

    public static $messages = [
        'first_name.required'               => 'El campo no puede quedar vacío.',
        'first_name.min'                    => 'El nombre debe tener al menos 2 caracteres.',
        'first_name.max'                    => 'El nombre debe tener como máximo 50 caracteres.',
        'first_name.string'                 => 'No cumple el formato de texto.',
        
        'last_name.required'                => 'El campo no puede quedar vacío.',
        'last_name.min'                     => 'El apellido debe tener al menos 2 caracteres.',
        'last_name.max'                     => 'El apellido debe tener como máximo 50 caracteres.',
        'last_name.string'                  => 'No cumple el formato de texto.',

        'email.required'                    => 'El campo no puede quedar vacío.',
        'email.email'                       => 'El email no cumple el formato.',
        'email.unique'                      => 'El email ya se encuentra en uso.',
        
        'identification_card_number.required'   => 'El campo no puede quedar vacío.',
        'identification_card_number.min'        => 'El DNI / PASAPORTE debe tener al menos 5 caracteres.',
        'identification_card_number.max'        => 'El DNI / PASAPORTE debe tener como máximo 50 caracteres.',
        'identification_card_number.unique'     => 'El DNI / PASAPORTE ya se encuentra en uso.',
        
        'date_of_birth.required'            => 'El campo no puede quedar vacío.',
        'date_of_birth.date'                => 'No cumple el formato de fecha.',
        
        'picture.image'                     =>'No cumple el formato de imagen',

    ];


    public static function isInAInitiatedReservation($id)
    {
        $reservation = Reservation::whereHas('client', function($q) use ($id){
            $q->where('client_id',$id);
        })
        ->where('reservation_status',2)
        ->get();
        
        if($reservation->count() > 0)
        {   
            return true;
        }
        return false;
    }

    
}
