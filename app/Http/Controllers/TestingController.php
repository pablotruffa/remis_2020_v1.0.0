<?php

namespace App\Http\Controllers;

use App\Models\Audit;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Deposit;
use App\Models\Vehicle;
use App\Models\RemisUsers;
use App\Models\Reservation;
use App\Models\Presenteeism;
use Illuminate\Http\Request;
use App\Models\DriverBalance;
use App\Models\RemisUserLevel;
use App\Models\ReservationLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class TestingController extends Controller
{
      public function index()
      {   
            $personas =[
                  ['nombre'=>'Pablo','edad'=>28],
                  ['nombre'=>'Lorena','edad'=>30],
                  ['nombre'=>'Juan','edad'=>45],
            ]; 

            $filtered = [];

            $filtered[]= array_filter($personas,function($per){
                  if($per['edad'] <= 29){
                        return $per;
                  }
            });
            
            dd($filtered);
      }     
}
