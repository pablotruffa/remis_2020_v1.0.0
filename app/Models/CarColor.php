<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CarColor
 *
 * @property int $id
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarColor whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CarColor extends Model
{   
    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = 'car_colors';

    /**
     * @var array campo de asignación masiva permitida.
     */
    protected $fillable = ['color'];

    /**
     * @static $rules reglas de validación.
     */
    public static $rules = [
        'color' =>'required|string|min:2|max:50|unique:car_colors,color'
    ];

    /**
     * @static $messages mensajes de validación.
     */
    public static $messages = [
        'color.required' => 'El campo no puede quedar vacío.',
        'color.min' => 'El color debe tener al menos 2 caracteres.',
        'color.max' => 'El color debe tener como máximo 50 caracteres.',
        'color.unique' => 'El color ya se encuentra en uso.',
        'color.string' => 'No cumple el formato de texto.',
    ];
}
