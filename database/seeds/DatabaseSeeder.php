<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PresenteeismTableSeeder::class);
        $this->call(ColorTableSeeder::class);
        $this->call(CarBrandTableSeeder::class);
        $this->call(CancellationReasonsTableSeeder::class);
        $this->call(ReservationStatusTableSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(VehicleListTableSeeder::class);
        $this->call(DriverTableSeeder::class);
        $this->call(InsertReservationTableSeeder::class);
        $this->call(InsertLevelOnTableUserLevelTableSeeder::class);
        $this->call(RemisUsersTableSeeder::class);
    }
}
