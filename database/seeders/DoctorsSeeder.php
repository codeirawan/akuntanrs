<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DoctorsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Set locale to Indonesian

        // Fetch all specialty IDs
        $specializations = DB::table('specialties')->pluck('id')->toArray();

        // Titles (gelar) for Indonesian doctors
        $titles = ['Dr.', 'drg.', 'Sp. OG', 'Sp. An', 'Sp. THT', 'Sp. KJ', 'Sp. PD', 'Sp. S'];

        foreach (range(1, 20) as $index) {
            DB::table('doctors')->insert([
                'name' => $faker->firstName . ' ' . $faker->lastName . ' ' . $faker->randomElement($titles), // Adding titles
                'specialty_id' => $faker->randomElement($specializations),
                'contact' => $faker->phoneNumber,
                'address' => $faker->address,
                'created_by' => 1, // Assuming user with ID 1 is the creator
                'updated_by' => null,
            ]);
        }
    }
}
