<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRemisUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remis_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 150)->unique();
            $table->string('password', 255);
            $table->integer('level_id')->unsigned()->nullable();
            $table->rememberToken();
            $table->softDeletes('deleted_at');
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
        Schema::dropIfExists('remis_users');
    }
}
