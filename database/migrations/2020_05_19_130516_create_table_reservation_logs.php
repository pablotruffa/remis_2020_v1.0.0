<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReservationLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('confirmation_number')->unique()->unsigned();
            $table->text('data');
            $table->timestamps();
            $table->foreign('confirmation_number')->references('confirmation_number')->on('reservations');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_logs');
    }
}
