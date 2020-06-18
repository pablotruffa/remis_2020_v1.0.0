<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('car_colors')->insert([
            ['color'    =>'Rojo'],
            ['color'    =>'Azul'],
            ['color'    =>'Negro'],
            ['color'    =>'Blanco'],
            ['color'    =>'Gris'],
            ['color'    =>'Verde'],
            ['color'    =>'Amarillo'],
            ['color'    =>'Naranja'],
            ['color'    =>'Marrón'],
            ['color'    =>'Rosa'],
            ['color'    =>'Beige'],

        ]);
        DB::table('car_colors')->update([
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
  
    }
}
