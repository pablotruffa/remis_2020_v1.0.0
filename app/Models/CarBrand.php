<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CarBrand
 *
 * @property int $id
 * @property string $brand
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CarBrand whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CarBrand extends Model
{   
    
    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = 'car_brands';
    
    /**
     * @var array campo de asignación masiva permitida.
     */
    protected $fillable = ['brand'];
    
    /**
     * @static $rules reglas de validación.
     */
    public static $rules = [
        'brand' =>'required|min:2|string|max:50|unique:car_brands,brand'
    ];

    /**
     * @static $messages mensajes de validación.
     */
    public static $messages = [
        'brand.required' => 'El campo no puede quedar vacío.',
        'brand.min' => 'El nombre debe tener al menos 2 caracteres.',
        'brand.max' => 'El nombre debe tener como máximo 50 caracteres.',
        'brand.unique' => 'El nombre ya se encuentra en uso.',
        'brand.string' => 'No cumple el formato de texto.',

    ];
}
