<?php

namespace App\Http\Controllers;

use App\Models\RemisUsers;
use Illuminate\Http\Request;
use App\Models\RemisUserLevel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {   
        $request->validate(RemisUsers::$loginRules);
        if(!Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
        {   
            $message = [
                'class'     =>'danger',
                'title'     =>'Error!',
                'content'   => 'Credenciales incorrectas.',
            ];
            return redirect()->back()->with('message',$message);
        }
        $user = Auth::user();
        $message = [
            'class'     =>'success',
            'title'     =>'Éxito!',
            'content'   => "Bienvenido $user->email",
        ];
        
        $level = RemisUserLevel::with('user')->where('id',$user->level_id)->first();
        
        $request->session()->put('level', $level->level);
        
        return redirect()->route('home')->with('message',$message);

    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        $message = [
            'class'     =>'success',
            'title'     =>'Sesión cerrada',
            'content'   => "Hasta la próxima!",
        ];
        return redirect()->route('auth.login')->with('message',$message);

    }





}
