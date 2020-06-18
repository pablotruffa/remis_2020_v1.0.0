<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarBrand extends Model
{   

    protected $table = 'car_brands';

    protected $fillable = ['brand'];

    public static $rules = [
        'brand' =>'required|min:2|string|max:50|unique:car_brands,brand'
    ];

    public static $messages = [
        'brand.required' => 'El campo no puede quedar vacío.',
        'brand.min' => 'El nombre debe tener al menos 2 caracteres.',
        'brand.max' => 'El nombre debe tener como máximo 50 caracteres.',
        'brand.unique' => 'El nombre ya se encuentra en uso.',
        'brand.string' => 'No cumple el formato de texto.',

    ];
}
