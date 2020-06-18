<?php

use Illuminate\Database\Seeder;

class DriverTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drivers')->insert([
            [
                'first_name'                    => 'Andres',
                'last_name'                     => 'Peralta',
                'email'                         => 'aperalta@outlook.com',
                'identification_card_number'    => '12589741',
                'car_license'                   => '12589741',
                'assigned_vehicle'              => 1,
                'date_of_birth'                 => '1960-01-25',
                'picture'                       => null,
                'presenteeism'                  => 1,
            ],
            [
                'first_name'                    =>'Ricardo',
                'last_name'                     =>'Ciancilla',
                'email'                         =>'ricky1991@outlook.com',
                'identification_card_number'    =>'36589741',
                'car_license'                   =>'36589741',
                'assigned_vehicle'              =>2,
                'date_of_birth'                 =>'1991-07-28',
                'picture'                       => null,
                'presenteeism'                  => 1,
            ],
            [
                'first_name'                    =>'Marta',
                'last_name'                     =>'Redondo',
                'email'                         =>'martitaricotera@yahoo.com',
                'identification_card_number'    =>'30285144',
                'car_license'                   =>'30285144',
                'assigned_vehicle'              => 3,
                'date_of_birth'                 =>'1987-11-03',
                'picture'                       => null,
                'presenteeism'                  => 1,
            ],

        ]);
        DB::table('drivers')->update([
            'created_at'    =>now(),
            'updated_at'    =>now(),
        ]);
        
    }
}
