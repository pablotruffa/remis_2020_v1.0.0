<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVehicle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('patent')->unique();
            $table->string('model');
            $table->year('year');
            $table->string('picture')->nullable();
            $table->integer('id_brand')->unsigned()->default(1);
            $table->integer('id_color')->unsigned()->default(1);
         
            $table->foreign('id_brand')->references('id')->on('car_brands');
            $table->foreign('id_color')->references('id')->on('car_colors');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
