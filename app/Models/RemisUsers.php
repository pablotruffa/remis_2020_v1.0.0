<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\RemisUserLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\RemisUsers
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property int|null $level_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RemisUserLevel|null $level
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RemisUsers onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereLevelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RemisUsers whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RemisUsers withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\RemisUsers withoutTrashed()
 * @mixin \Eloquent
 */
class RemisUsers extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    /**
     * @var string La tabla que comunica al modelo.
     */
    protected $table = "remis_users";

    /**
     * @var array campo de asignación masiva permitida.
     */
    protected $fillable = ['email','password','level_id'];

    /**
     * @var string campo invisible en la relación de modelos.
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @static $loginRules reglas de validación.
     */
    public static $loginRules = [
    	'email' => 'required|email',
    	'password' => 'required|min:3'
    ];

    /**
     * @static $updatePasswordRules reglas de validación.
     */
    public static $updatePasswordRules = [
        'current-password'                  => 'required',
        'new-password'                      => 'required|confirmed|min:4|max:10',
    ];

    /**
     * @static $updatePasswordMessages mensajes de validación.
     */
    public static $updatePasswordMessages = [
        'current-password.required'  => 'Campo requerido.',
        
        'new-password.required'      => 'Campo requerido.',
        'new-password.confirmed'     => 'La nueva contraseña y la confirmación no coinciden.',
        'new-password.min'           => '4 caracters como mínimo.',
        'new-password.max'           => '10 caracters como máximo.',
    ];
    
    /**
     * Relación de Eloquent
     *
     * @return void
     */
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
