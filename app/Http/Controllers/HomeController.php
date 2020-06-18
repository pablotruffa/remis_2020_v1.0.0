<?php

namespace App\Http\Controllers;
use App\Models\RemisUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {   
        return view('welcome');
    }

}
