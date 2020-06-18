<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleListTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vehicles')->insert([
            [
                'patent'        =>'AE037XD',
                'model'         =>'Nuevo Polo',
                'year'          => 2020,
                'picture'       => null,
                'id_brand'      => 51,
                'id_color'      => 4,
            ],
            [
                'patent'        =>'RUF055',
                'model'         =>'Kangoo',
                'year'          => 2005,
                'picture'       => null,
                'id_brand'      => 40,
                'id_color'      => 2,
            ],
            [
                'patent'        =>'RXD578',
                'model'         =>'307',
                'year'          => 2016,
                'picture'       => null,
                'id_brand'      => 37,
                'id_color'      => 5,
            ],
            
        ]);
        DB::table('vehicles')->update([
            'created_at'        => now(),
            'updated_at'        => now(), 
        ]);
    }
}
