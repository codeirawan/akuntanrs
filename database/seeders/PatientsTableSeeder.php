<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('patients')->insert([
                'name' => $faker->name,
                'nik' => $faker->unique()->numerify('##########'), // Unique NIK
                'dob' => $faker->date,
                'gender' => $faker->randomElement(['p', 'l']), // 'p' for female, 'l' for male
                'address' => $faker->address,
                'description' => $faker->sentence,
                'created_by' => 1, // Assuming user with ID 1 is the creator
                'updated_by' => null,
            ]);
        }
    }
}
