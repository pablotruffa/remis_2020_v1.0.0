<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancellationReason extends Model
{   
    
    protected $table = 'cancellation_reasons';

    protected $fillable = ['reason'];


    public static $rules = [
        'reason' =>'required|string|min:2|max:250|unique:cancellation_reasons,reason',
        
    ];

    public static $cancel_form = [
        'reason_id' => array(
            'required',
            'numeric',
            'integer',
            'regex:/^[1-9]+\d*/'
        ),
        'remark' => 'nullable|string|min:10|max:1500',
    ];

    public static $messages = [
        'reason.required'   => 'El campo no puede quedar vacío.',
        'reason.min'        => 'La razón debe tener al menos 2 caracteres.',
        'reason.max'        => 'La razón debe tener como máximo 250 caracteres.',
        'reason.unique'     => 'El razón ya se encuentra en uso.',
        'reason.string'     => 'No cumple el formato de texto.',

        'reason_id.required'    =>'Es necesario elegir una opcion para poder cancelar.',
        
        'remark.min'            =>'La observación debe tener un mínimo de 10 caracteres.',
        'remark.max'            =>'La observación debe tener un máximo de 10 caracteres.',
        'remark.string'         =>'La observación no cumple el formato de texto.',
    ];

}
