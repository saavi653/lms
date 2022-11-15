<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'first_name' => 'savita',
            'last_name' => 'sharma',
            'slug' => 'savita_sharma',
            'email' => 'saavi@gmail.com',
            'created_by' =>1,
            'gender' => 'female',
            'phone' => 9874635387,
            'password' => Hash::make('saavi12'),
            'image' => 'null',
            'email_status' => 1,
            'status'=> 1
        ]);
    }
}
