<?php

use Illuminate\Database\Seeder;

class CarBrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('car_brands')->insert([
            ['brand'    =>'Abarth'],
            ['brand'    =>'Alfa Romeo'],
            ['brand'    =>'Aston Martin'],
            ['brand'    =>'Audi'],
            ['brand'    =>'Bentley'],
            ['brand'    =>'BMW'],
            ['brand'    =>'Cadillac'],
            ['brand'    =>'Caterham'],
            ['brand'    =>'Chevrolet'],
            ['brand'    =>'Citroen'],
            ['brand'    =>'Dacia'],
            ['brand'    =>'Ferrari'],
            ['brand'    =>'Fiat'],
            ['brand'    =>'Ford'],
            ['brand'    =>'Honda'],
            ['brand'    =>'Infiniti'],
            ['brand'    =>'Isuzu'],
            ['brand'    =>'Iveco'],
            ['brand'    =>'Jaguar'],
            ['brand'    =>'Jeep'],
            ['brand'    =>'Kia'],
            ['brand'    =>'KTM'],
            ['brand'    =>'Lada'],
            ['brand'    =>'Lamborghini'],
            ['brand'    =>'Lancia'],
            ['brand'    =>'Land Rover'],
            ['brand'    =>'Lexus'],
            ['brand'    =>'Lotus'],
            ['brand'    =>'Maserati'],
            ['brand'    =>'Mazda'],
            ['brand'    =>'Mercedes-Benz'],
            ['brand'    =>'Mini'],
            ['brand'    =>'Mitsubishi'],
            ['brand'    =>'Morgan'],
            ['brand'    =>'Nissan'],
            ['brand'    =>'Opel'],
            ['brand'    =>'Peugeot'],
            ['brand'    =>'Piaggio'],
            ['brand'    =>'Porsche'],
            ['brand'    =>'Renault'],
            ['brand'    =>'Rolls-Royce'],
            ['brand'    =>'Seat'],
            ['brand'    =>'Skoda'],
            ['brand'    =>'Smart'],
            ['brand'    =>'SsangYong'],
            ['brand'    =>'Subaru'],
            ['brand'    =>'Suzuki'],
            ['brand'    =>'Tata'],
            ['brand'    =>'Tesla'],
            ['brand'    =>'Toyota'],
            ['brand'    =>'Volkswagen'],
            ['brand'    =>'Volvo'],
        ]);

        DB::table('car_brands')->update(
            [
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        );
        
     
    }
}

