<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $identification_card_number
 * @property string $date_of_birth
 * @property string|null $picture
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereIdentificationCardNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Client withoutTrashed()
 * @mixin \Eloquent
 */
class Client extends Model
{   
    use SoftDeletes;

    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = 'clients';
    
    /**
     * @var string campo invisible en la relación de modelos.
     */
    protected $hidden = ['pivot'];

    /**
     * @var array campo de asignación masiva permitida.
     */
    protected $fillable = ['first_name','last_name','email','identification_card_number','date_of_birth','picture'];

    /**
     * @static $rules reglas de validación.
     */
    public static $rules = [
        'first_name'                        =>'required|string|min:2|max:150',
        'last_name'                         =>'required|string|min:2|max:150',
        'email'                             =>'required|email|unique:clients,email',
        'identification_card_number'        =>'required|string|min:5|max:25|unique:clients,identification_card_number',
        'date_of_birth'                     =>'required|date',
        'picture'                           =>'image',
        
    ];

        
    /**
     * Reglas de validación
     *
     * @param  mixed $id
     * @return array
     */
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

    /**
     * @static $messages mensajes de validación.
     */
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

    
    /**
     * isInAInitiatedReservation
     *
     * @param  mixed $id
     * @return bool
     */
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
