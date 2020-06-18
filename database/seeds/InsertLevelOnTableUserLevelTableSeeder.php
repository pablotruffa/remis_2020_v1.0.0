<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InsertLevelOnTableUserLevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_level')->insert([
            ['level'=>'Admin'],
            ['level'=>'Driver'],
            ['level'=>'Root'],
        ]);
        
        DB::table('user_level')->update([
            'created_at'        => now(),
            'updated_at'        => now(), 
        ]);

    }
}
