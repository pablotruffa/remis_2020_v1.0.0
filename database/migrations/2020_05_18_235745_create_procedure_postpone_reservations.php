<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcedurePostponeReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        //Comment when testing...
        //DB::unprepared('DROP procedure IF EXISTS postpone_reservations');
        //DB::unprepared('CREATE PROCEDURE postpone_reservations() UPDATE reservations SET reservation_status = 3 WHERE travel_date < CURRENT_DATE AND reservation_status = 1');
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
