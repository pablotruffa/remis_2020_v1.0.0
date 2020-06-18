<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CancellationReasonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cancellation_reasons')->insert([
            ['reason'    =>'El cliente canceló.'],
            ['reason'    =>'El cliente no se presentó.'],
            ['reason'    =>'El cliente encontró mejor precio en otro lugar.'],
            ['reason'    =>'Cliente dado de baja'],
            
            ['reason'    =>'El chofer no se presentó.'],
            ['reason'    =>'Chofer dado de baja'],

            ['reason'    =>'Problemas con el vehículo'],

            ['reason'    =>'La empresa cancela la reserva.'],
            ['reason'    =>'Cancelación por fuerza mayor.'],
            ['reason'    =>'Reserva duplicada.'],
            ['reason'    =>'Fecha errónea.'],
            ['reason'    =>'Reserva de prueba.'],
            ['reason'    =>'Otras razones'],

        ]);
        DB::table('cancellation_reasons')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);    
                
        
    }
}
