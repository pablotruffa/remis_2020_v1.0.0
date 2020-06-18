<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventPostponeReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {  
       //Comment when testing...
       DB::unprepared('SET GLOBAL event_scheduler = ON');
       DB::unprepared('DROP EVENT IF EXISTS postpone_yesterday_reservations');
       DB::unprepared("CREATE EVENT postpone_yesterday_reservations ON SCHEDULE EVERY 24 HOUR STARTS '2020-05-18 00:00:00' DO CALL postpone_reservations()");
     
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
