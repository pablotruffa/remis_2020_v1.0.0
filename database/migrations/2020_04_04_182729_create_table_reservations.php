<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableReservations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('confirmation_number')->unique()->unsigned();
            $table->date('travel_date');
            $table->time('travel_time');
            $table->string('origin');
            $table->string('destiny');
            $table->integer('vehicle_quantity');
            $table->decimal('price',10,2);
            $table->decimal('commission_percentage');
            $table->integer('reservation_status')->unsigned();
            $table->timestamps();
    
            $table->foreign('reservation_status')->references('id')->on('reservation_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
