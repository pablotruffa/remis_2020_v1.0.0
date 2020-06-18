<?php

use Illuminate\Database\Seeder;

class PresenteeismTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('presenteeism')->insert([
            ['state'         =>'Presente'],
            ['state'         =>'Ausente'],
        ]);

        DB::table('presenteeism')->update([
            'created_at'        => now(),
            'updated_at'        => now(), 
        ]);
    }
}
