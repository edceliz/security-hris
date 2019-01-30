,
'created_by' => 1<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
            'name' => 'Admin',
            'email' => 'admin@edceliz.com',
            'password' => bcrypt('adminadmin'),
            'role' => 1,
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'created_by' => 1,
            'updated_by' => 1
        ], [
            'name' => 'Random HR',
            'email' => 'randomhr@edceliz.com',
            'password' => bcrypt('randomhrhr'),
            'role' => 2,
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'created_by' => 1,
            'updated_by' => 1
        ], [
            'name' => 'Random Guest',
            'email' => 'randomguest@edceliz.com',
            'password' => bcrypt('randomguest'),
            'role' => 3,
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
            'created_by' => 1,
            'updated_by' => 1
        ]]);
        // $this->call(UsersTableSeeder::class);
    }
}
