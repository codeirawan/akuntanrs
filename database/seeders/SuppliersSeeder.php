<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class SuppliersSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('suppliers')->insert([
                'name' => $faker->company,
                'contact' => $faker->phoneNumber,
                'address' => $faker->address,
                'created_by' => 1, // Assuming user with ID 1 is the creator
                'updated_by' => null,
            ]);
        }
    }
}
