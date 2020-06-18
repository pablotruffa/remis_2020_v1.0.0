<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertReservationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reservations')->insert([
            [
                'confirmation_number'   => time(),
                'travel_date'           => '2019-05-17',
                'travel_time'           => '20:00:00',
                'origin'                => 'Salta',
                'destiny'               => 'Capital Federal',
                'vehicle_quantity'      => '1',
                'price'                 => '3000',
                'commission_percentage' => '20',
                'reservation_status'    => 3,
            ],
            [
                'confirmation_number'   => time() + 1,
                'travel_date'           => '2020-05-17',
                'travel_time'           => '23:59:59',
                'origin'                => 'Berazategui',
                'destiny'               => 'Capital Federal',
                'vehicle_quantity'      => '1',
                'price'                 => '1050',
                'commission_percentage' => '20',
                'reservation_status'    => 3,
            ],
            [
                'confirmation_number'   => time() + 2,
                'travel_date'           => date('Y-m-d', time()),
                'travel_time'           => '23:59:59',
                'origin'                => 'Lanus',
                'destiny'               => 'Constitucion',
                'vehicle_quantity'      => '2',
                'price'                 => '1800',
                'commission_percentage' => '20',
                'reservation_status'    => 1,
            ],
            [
                'confirmation_number'   => time() + 3,
                'travel_date'           => date('Y-m-d', time()),
                'travel_time'           => '23:59:59',
                'origin'                => 'Quilmes',
                'destiny'               => 'Avellaneda',
                'vehicle_quantity'      => '3',
                'price'                 => '1500',
                'commission_percentage' => '20',
                'reservation_status'    => 1,
            ],
            [
                'confirmation_number'   => time() + 4,
                'travel_date'           => date('Y-m-d', time()),
                'travel_time'           => '23:59:59',
                'origin'                => 'Corrientes',
                'destiny'               => 'La Pampa',
                'vehicle_quantity'      => '1',
                'price'                 => '6000',
                'commission_percentage' => '30',
                'reservation_status'    => 2,
            ],
            
        ]);
        
        DB::table('reservations')->update([
                'created_at'        => now(),
                'updated_at'        => now(), 
        ]);
        
        DB::table('reservation_has_driver')->insert([
            [
                'reservation_id'    =>5,
                'driver_id'         =>2,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
         
        DB::table('reservation_has_client')->insert([
            [
                'reservation_id'    =>1,
                'client_id'         =>1,
            ],
            [
                'reservation_id'    =>2,
                'client_id'         =>2,
            ],
            [
                'reservation_id'    =>3,
                'client_id'         =>3,
            ],
            [
                'reservation_id'    =>4,
                'client_id'         =>3,
            ],
            [
                'reservation_id'    =>5,
                'client_id'         =>1,
            ],
            
        ]);
        
        DB::table('reservation_has_client')->update([
            'created_at'        => now(),
            'updated_at'        => now(), 
        ]);

    }
}
