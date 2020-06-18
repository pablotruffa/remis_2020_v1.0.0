<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReservationStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservation_status')->insert([
            ['status'   =>'Confirmada'],
            ['status'   =>'Iniciada'],
            ['status'   =>'Postergada'],
            ['status'   =>'Cancelada'],
            ['status'   =>'Concretada'],

        ]);
        
        DB::table('reservation_status')->update([
            'created_at'        => now(),
            'updated_at'        => now(), 
        ]);
       
    }
}
