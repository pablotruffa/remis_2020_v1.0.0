<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\RemisUserLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class RemisUsers extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    protected $table = "remis_users";
    protected $fillable = ['email','password','level_id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public static $loginRules = [
    	'email' => 'required|email',
    	'password' => 'required|min:3'
    ];

    public static $updatePasswordRules = [
        'current-password'                  => 'required',
        'new-password'                      => 'required|confirmed|min:4|max:10',
    ];

    public static $updatePasswordMessages = [
        'current-password.required'  => 'Campo requerido.',
        
        'new-password.required'      => 'Campo requerido.',
        'new-password.confirmed'     => 'La nueva contraseña y la confirmación no coinciden.',
        'new-password.min'           => '4 caracters como mínimo.',
        'new-password.max'           => '10 caracters como máximo.',
    ];

    public function level()
    {
        return $this->belongsTo(RemisUserLevel::class,'level_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
