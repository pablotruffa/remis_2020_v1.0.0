<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarColor extends Model
{   

    protected $table = 'car_colors';

    protected $fillable = ['color'];

    public static $rules = [
        'color' =>'required|string|min:2|max:50|unique:car_colors,color'
    ];

    public static $messages = [
        'color.required' => 'El campo no puede quedar vacío.',
        'color.min' => 'El color debe tener al menos 2 caracteres.',
        'color.max' => 'El color debe tener como máximo 50 caracteres.',
        'color.unique' => 'El color ya se encuentra en uso.',
        'color.string' => 'No cumple el formato de texto.',
    ];
}
