<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RemisUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('remis_users')->insert([
            ['email'        => 'root@remiseria.com',
            'password'      => Hash::make('1234'),
            'level_id'      => 3,
            'created_at'    => now(),
            'updated_at'    => now(),
            ],
            ['email'        => 'aperalta@outlook.com',
            'password'      => Hash::make('1234'),
            'level_id'      => 1,
            'created_at'    => now(),
            'updated_at'    => now(),
            ],
            ['email'        => 'ricky1991@outlook.com',
            'password'      => Hash::make('1234'),
            'level_id'      => 2,
            'created_at'    => now(),
            'updated_at'    => now(),
            ],
            ['email'        => 'martitaricotera@yahoo.com',
            'password'      => Hash::make('1234'),
            'level_id'      => 2,
            'created_at'    => now(),
            'updated_at'    => now(),
            ],


        ]);
    }
}
