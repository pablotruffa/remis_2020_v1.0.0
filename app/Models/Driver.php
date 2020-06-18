<?php

namespace App\Models;

use App\Models\Vehicle;
use App\Models\Reservation;
use App\Models\Presenteeism;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{   
    use SoftDeletes;
    protected $table = 'drivers';
    protected $hidden = ['pivot'];

    protected $fillable = ['first_name','last_name','email','identification_card_number','car_license','date_of_birth','picture','presenteeism'];

    public static $rules = [
        'first_name'                    =>'required|string|min:2|max:150',
        'last_name'                     =>'required|string|min:2|max:150',
        'email'                         =>'required|email|unique:drivers,email',
        'identification_card_number'    =>'required|string|min:5|max:25|unique:drivers,identification_card_number',
        'car_license'                   =>'required|min:5|max:25|unique:drivers,car_license',
        'date_of_birth'                 =>'required|date',
        'picture'                       =>'image',
        
    ];

    public static function edit_rules($id){
        return [
            'first_name'                    =>'required|min:2|max:150',
            'last_name'                     =>'required|min:2|max:150',
            'email'                         =>'required|email|unique:drivers,email,'.$id,
            'identification_card_number'    =>'required|string|min:5|max:25|unique:drivers,identification_card_number,'.$id,
            'car_license'                   =>'required|min:5|max:25|unique:drivers,car_license,'.$id,
            'date_of_birth'                 =>'required|date',
            'picture'                       =>'image',
        ];
    }

    public static $messages = [
        'first_name.required' => 'El campo no puede quedar vacío.',
        'first_name.min' => 'El nombre debe tener al menos 2 caracteres.',
        'first_name.max' => 'El nombre debe tener como máximo 50 caracteres.',
        'first_name.string' => 'No cumple el formato de texto.',
        
        'last_name.required' => 'El campo no puede quedar vacío.',
        'last_name.min' => 'El apellido debe tener al menos 2 caracteres.',
        'last_name.max' => 'El apellido debe tener como máximo 50 caracteres.',
        'last_name.string' => 'No cumple el formato de texto.',

        'email.required'                    => 'El campo no puede quedar vacío.',
        'email.email'                       => 'El email no cumple el formato.',
        'email.unique'                      => 'El email ya se encuentra en uso.',
        
        'identification_card_number.required' => 'El campo no puede quedar vacío.',
        'identification_card_number.min' => 'El DNI / PASAPORTE debe tener al menos 5 caracteres.',
        'identification_card_number.max' => 'El DNI / PASAPORTE debe tener como máximo 50 caracteres.',
        'identification_card_number.unique' => 'El DNI / PASAPORTE ya se encuentra en uso.',
        
        'car_license.required' => 'El campo no puede quedar vacío.',
        'car_license.min' => 'La licencia de conducir debe tener al menos 5 caracteres.',
        'car_license.max' => 'La licencia de conducir debe tener como máximo 50 caracteres.',
        'car_license.unique' => 'La licencia de conducir ya se encuentra registrada.',
        
        'date_of_birth.required' => 'El campo no puede quedar vacío.',
        'date_of_birth.date' => 'No cumple el formato de fecha.',
        
        'picture.image' => 'No cumple el formato de imagen.',

    ];

    public function vehicle()
    {
        return $this-> belongsTo(Vehicle::class,'assigned_vehicle');
    }

    public function reservation()
    {
        return $this->belongsToMany(Reservation::class,'reservation_has_driver','driver_id','reservation_id');
    }

    public function presenteeism()
    {
        return $this->belongsTo(Presenteeism::class, 'presenteeism');
    }
    /**
     * Getters -----------------------------------------------------------
     */

    public static function driverHasReservations(Driver $driver)
    {
        $reservations = [];
        
        if($driver->reservation->count() > 0){
                
            foreach($driver->reservation as $reservation){
                if($reservation->reservation_status == 2)
                {   
                    $reservations[]=$reservation->id;  
                }
            }
            
        }
        return $reservations;

    }
}
