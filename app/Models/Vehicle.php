<?php

namespace App\Models;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{     
    protected $table = 'vehicles';

    protected $fillable = ['patent','model','year','picture','id_color','id_brand'];

    public static $rules = [
        'patent' =>'required|min:6|max:10|unique:vehicles,patent',
        'model' =>'required|min:1|max:150',
        'year' =>'required|date_format:Y',
        'picture' =>'image',
        'id_color' => array(
            'required',
            'numeric',
            'integer',
            'regex:/^[1-9]+\d*/'
        ),
        'id_brand' => array(
            'required',
            'numeric',
            'integer',
            'regex:/^[1-9]+\d*/'
        ),
    ];

    public static function edit_rules($id)
    {
        return [
            'patent' =>'required|min:6|max:10|unique:vehicles,patent,'.$id,
            'model' =>'required|min:1|max:200',
            'year' =>'required|date_format:Y',
            'picture' =>'image',
            'id_color' => array(
                'required',
                'numeric',
                'integer',
                'regex:/^[1-9]+\d*/'

            ),
            'id_brand' => array(
                'required',
                'numeric',
                'integer',
                'regex:/^[1-9]+\d*/'
            ),
        ];
    }

    public static $messages = [
        'patent.required' => 'El campo no puede quedar vacío.',
        'patent.min' => 'La patente debe tener al menos 6 caracteres.',
        'patent.max' => 'La patente debe tener como máximo 10 caracteres.',
        'patent.unique' => 'La patente ya se encuentra en uso.',
        
        'model.required' => 'El campo no puede quedar vacío.',
        'model.min' => 'El modelo debe tener al menos 1 caracter.',
        'model.max' => 'La modele debe tener como máximo 200 caracteres.',
        
        'year.required' => 'El campo no puede quedar vacío.',
        'year.date_format' => 'No cumple el formato de fecha anual. Ej: 1990',
        
        'picture.image' => 'No cumple el formato de imagen.',
        
        'id_color.required' => 'El campo no puede quedar vacío.',
        
        'id_brand.required' => 'El campo no puede quedar vacío.',
    
    ];


    /**
     * Relationships
     */

     public function brand()
     {  
         /**
         * Clase
         * FK en la tabla del modelo (Vehicle)
         * PK de la tabla que relaciona el modelo (CarBrand)
         */
         return $this->belongsTo('App\Models\CarBrand', 'id_brand', 'id');
     }

     public function color()
     {
         return $this->belongsTo('App\Models\CarColor', 'id_color', 'id');
     }

     public function driver()
     {
         return $this->hasOne('App\Models\Driver','assigned_vehicle');
     }


     public static function isInAInitiatedReservation($id)
     {
        $vehicle = Vehicle::findOrFail($id);
        $reservation = Reservation::whereHas('driver', function($q) use ($vehicle){
            $q->where('assigned_vehicle',$vehicle->id);
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
