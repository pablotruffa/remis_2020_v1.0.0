<?php

namespace App\Models;

use App\Models\Vehicle;
use App\Models\Reservation;
use App\Models\Presenteeism;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Driver
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $identification_card_number
 * @property string $car_license
 * @property int|null $assigned_vehicle
 * @property string $date_of_birth
 * @property string|null $picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \App\Models\Presenteeism $presenteeism
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reservation[] $reservation
 * @property-read int|null $reservation_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Driver onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereAssignedVehicle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereCarLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereIdentificationCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver wherePresenteeism($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Driver whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Driver withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Driver withoutTrashed()
 * @mixin \Eloquent
 */
class Driver extends Model
{   
    use SoftDeletes;

    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = 'drivers';

    /**
     * @var string campo invisible en la relación de modelos.
     */
    protected $hidden = ['pivot'];

    /**
     * @var array campos de asignación masiva permitida.
     */
    protected $fillable = ['first_name','last_name','email','identification_card_number','car_license','date_of_birth','picture','presenteeism'];

    /**
     * @static $rules reglas de validación.
     */
    public static $rules = [
        'first_name'                    =>'required|string|min:2|max:150',
        'last_name'                     =>'required|string|min:2|max:150',
        'email'                         =>'required|email|unique:drivers,email',
        'identification_card_number'    =>'required|string|min:5|max:25|unique:drivers,identification_card_number',
        'car_license'                   =>'required|min:5|max:25|unique:drivers,car_license',
        'date_of_birth'                 =>'required|date',
        'picture'                       =>'image',
        
    ];

        
    /**
     * Reglas de validación.
     *
     * @param  mixed $id
     * @return array
     */
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

    /**
     * @static $messages mensajes de validación.
     */
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
    
    /**
     * Relación de eloquent
     *
     * @return void
     */
    public function vehicle()
    {
        return $this-> belongsTo(Vehicle::class,'assigned_vehicle');
    }

    /**
     * Relación de eloquent
     *
     * @return void
     */
    public function reservation()
    {
        return $this->belongsToMany(Reservation::class,'reservation_has_driver','driver_id','reservation_id');
    }

    /**
     * Relación de eloquent
     *
     * @return void
     */
    public function presenteeism()
    {
        return $this->belongsTo(Presenteeism::class, 'presenteeism');
    }
   

        
    /**
     * driverHasReservations
     *
     * @param  object $driver
     * @return array reservas
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
