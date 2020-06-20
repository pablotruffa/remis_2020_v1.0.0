<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CancellationReason
 *
 * @property int $id
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CancellationReason whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CancellationReason extends Model
{   
        
    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = 'cancellation_reasons';
    
    /**
     * @var array campo de asignación masiva permitida.
     */
    protected $fillable = ['reason'];

    /**
     * @static $rules reglas para de validación.
     */
    public static $rules = [
        'reason' =>'required|string|min:2|max:250|unique:cancellation_reasons,reason',
        
    ];

    /**
     * @static $cancel_form reglas de validación.
     */
    public static $cancel_form = [
        'reason_id' => array(
            'required',
            'numeric',
            'integer',
            'regex:/^[1-9]+\d*/'
        ),
        'remark' => 'nullable|string|min:10|max:1500',
    ];

    /**
     * @static $messages mensajes personalizados para la  validación.
     */
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
