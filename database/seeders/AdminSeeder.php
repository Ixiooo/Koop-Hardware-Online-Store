<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'first_name' => 'Administrator',
            'last_name' => 'Hardware',
            'middle_initial' => 'Koop',
            'sex' => 'Male',
            'mobile' => '0918273645261',
            'city' => 'Batangas',
            'barangay' => 'Tinga Itaas',
            'barangay_code' => '041005114',
            'user_type' => 'admin',
            'email' => 'koophardware.onlinestore@gmail.com',
            'password' => Hash::make('koophardware-sidc'),
        ]);
    }
}
