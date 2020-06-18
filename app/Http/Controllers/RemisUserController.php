<?php

namespace App\Http\Controllers;

use App\Models\RemisUsers;
use Illuminate\Http\Request;
use App\Models\RemisUserLevel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RemisUserController extends Controller
{
    public function index()
    {
        $users = RemisUsers::whereHas('level',function($q){
            $q->whereIn('level_id',[1,2]);
        })
        ->withTrashed()
        ->get();

        if(count($users) == 0)
        {   
            $message = [
                'class'     =>'info',
                'title'     =>'Sin resultados!',
                'content'   =>'No se registran usuarios activos.',
            ];
            return redirect()->back()->with('message',$message);
        }

        $levels = RemisUserLevel::all()->except(3);
        foreach($levels as $level)
        {
            if($level->level == 'Admin'){
                $level->level = 'Administrador';
            }else{
                $level->level = 'Chofer';
            }
        }
        $options = ['Permitido','Denegado'];
        return view('remisUsers.users',compact('users','levels','options'));
    }

    public function edit(Request $request, $id)
    {   
        //Validation
        $user   = RemisUsers::withTrashed()->findOrFail($id);
        $level  = RemisUserLevel::findOrFail($request->input('level'));
        $permit = $request->input('permit');

        if(!in_array($permit,[202,403]))
        {
            $message = [
                'class'     =>'danger',
                'title'     =>'Denegado!',
                'content'   =>'No se pudo editar al usuario.',
            ];
            return redirect()->back()->with('message',$message);
        }else{
            $user->deleted_at = ($permit == 202)? null:now();
        }

        $user->level_id = $level->id;
        $user->save();
        $message = [
            'class'     =>'success',
            'title'     =>'Acción completada!',
            'content'   =>"Usuario $user->email modificado exitosamente.",
        ];
        return redirect()->back()->with('message',$message);
        
    }

    public function create(Request $request, $id)
    {
        //Validation
        $driver = Driver::findOrFail($id);

        $newUser = [
            'email'        =>$driver->email,
            'password'     =>Hash::make($driver->car_license),
            'level_id'     =>2,
            'created_at'   =>now(),
            'updated_at'   =>now(),
        ];
        RemisUsers::create($newUser);
    }

    public function delete($id)
    {
        if(!RemisUsers::alwaysAnAdmin())
        {
            $message = [
                'class'     =>'danger',
                'title'     =>'Denegado!',
                'content'   =>'No se puede eliminar al último administrador.',
            ];
            return redirect()->back()->with('message',$message);   
        }
        
        $driver = RemisUsers::findOrFail($id);
        $driver->delete();


    }

    public function formPassword()
    {
        return view('drivers.profilePassword');
    }

    public function editPassword(Request $request)
    {   
        $request->validate(RemisUsers::$updatePasswordRules, RemisUsers::$updatePasswordMessages);

        $currentPassword    = $request->input('current-password');
        $newPassword        = $request->input('new-password');
        $confirmedPassword  = $request->input('password_confirmation');
        
        if(!Hash::check($currentPassword, Auth::user()->password))
        {   
            $message = [
                'class'     =>'danger',
                'title'     =>'Denegado!',
                'content'   =>'Las credenciales ingresadas son incorrectas.',
            ];
            return redirect()->back()->with('message',$message);
        }else{

            $newPassword = Hash::make($newPassword);
            Auth::user()->password = $newPassword;
            Auth::user()->save();

            $message = [
                'class'     =>'success',
                'title'     =>'Actualizado!',
                'content'   =>'Las credenciales fueron actualizadas correctamente.',
            ];
            return redirect()->back()->with('message',$message);
        }
        
    }


}
