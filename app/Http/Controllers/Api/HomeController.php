<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {   
        $message = [
            'title'     => 'Bienvenid@ a Remis v.2020',
            'content'   => 'Este es un sitio para gestionar reservas de una remisería.'  
        ];
        return response()->json($message);
    }
    public function about()
    {
        return response()->json(['message' => 'Informacion acerca del sitio']);
    }
}
