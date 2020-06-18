<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\RemisUsers;
use Illuminate\Support\Facades\Auth;

class OnlyDriver
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = RemisUsers::with('level')->find(Auth::user()->id);
        if($user->level->level != 'Driver')
        {   
            $message = [
                'class'     =>'danger',
                'title'     =>'URL Restringida!',
                'content'   =>'No tienes permisos para acceder.',
            ];
            return redirect()->back()->with('message',$message);
        }
        
        return $next($request); 
    }
}
