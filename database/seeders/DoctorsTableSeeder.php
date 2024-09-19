<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DoctorsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Fetch all specialty IDs
        $specializations = DB::table('specialties')->pluck('id')->toArray();

        foreach (range(1, 20) as $index) {
            DB::table('doctors')->insert([
                'name' => $faker->name,
                'specialty_id' => $faker->randomElement($specializations),
                'contact' => $faker->phoneNumber,
                'address' => $faker->address,
                'created_by' => 1, // Assuming user with ID 1 is the creator
                'updated_by' => null,
            ]);
        }
    }
}
