<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            [
                'first_name'                    =>'Jorge',
                'last_name'                     =>'Gonzales',
                'email'                         =>'jgonzales@gmail.com',
                'identification_card_number'    =>'14589741',
                'date_of_birth'                 =>'1962-04-06',
                'picture'                       => null,
            ],
            [
                'first_name'                    =>'Susana',
                'last_name'                     =>'Ramos',
                'email'                         =>'sramos@yahoo.com',
                'identification_card_number'    =>'24589741',
                'date_of_birth'                 =>'1975-09-28',
                'picture'                       => null,
            ],
            [
                'first_name'                    =>'Marcos',
                'last_name'                     =>'Andreani',
                'email'                         =>'mandreani@andreani.com',
                'identification_card_number'    =>'30285144',
                'date_of_birth'                 =>'1985-04-26',
                'picture'                       => null,
            ],
            
        ]);
            
        DB::table('clients')->update([
            'created_at'    =>now(),
            'updated_at'    =>now(),
        ]);
    }
}
