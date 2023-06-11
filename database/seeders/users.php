<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\support\facades\Hash;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('users')->count() == 0) {

            DB::table('users')->insert([
                [
                    'name' => "SuperAdmin",
                    'email' => "Superadmin@gmail.com",
                    'usertype' => "1",
                    'password' => Hash::make('Superadmin'),
                    'phone' => "6985326547",
                    'salary' => "0",
                ],
                [
                    'name' => "Admin",
                    'email' => "admin@gmail.com",
                    'usertype' => "3",
                    'password' => Hash::make('admin'),
                    'phone' => "6985326578",
                    'salary' => "25000",
                ],
                [
                    'name' => "Delivery",
                    'email' => "delivery@gmail.com",
                    'usertype' => "2",
                    'password' => Hash::make('delivery'),
                    'phone' => "6985335547",
                    'salary' => "15000",
                ],
                [
                    'name' => "Customer",
                    'email' => "customer@gmail.com",
                    'usertype' => "0",
                    'password' => Hash::make('customer'),
                    'phone' => "6985335588",
                    'salary' => "0",
                ],
            ]);
        } else {
            echo "\e [  -Data Already Saved, Therefore  Data Is Not Seeded ";
        }
    }
}
