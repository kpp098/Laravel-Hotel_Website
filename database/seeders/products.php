<?php

namespace Database\Seeders;

use Illuminate\support\facades\DB;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (DB::table('products')->count() == 0) {
            $faker = Faker::create();

            DB::table('products')->insert([
                [
                    'name' => $faker->word(),
                    'description' => $faker->sentence(10),
                    'image' => $faker->imageUrl($width = 640, $height = 480),
                    'price' => $faker->randomFloat(2, 10, 100),
                    'session' => "0",
                ],
                [
                    'name' => $faker->word(),
                    'description' => $faker->sentence(10),
                    'image' => $faker->imageUrl($width = 640, $height = 480),
                    'price' => $faker->randomFloat(2, 10, 100),
                    'session' => "1",
                ],
                [
                    'name' => $faker->word(),
                    'description' => $faker->sentence(10),
                    'image' => $faker->imageUrl($width = 640, $height = 480),
                    'price' => $faker->randomFloat(2, 10, 100),
                    'session' => "2",
                ],
            ]);
        } else {
            echo "\e[ -Data Already Saved, Therefore  Data Is Not Seeded ";
        }
    }
}
