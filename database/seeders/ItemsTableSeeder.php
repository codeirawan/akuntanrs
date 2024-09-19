<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 20) as $index) {
            DB::table('items')->insert([
                'code' => $faker->unique()->word,
                'name' => $faker->word,
                'unit' => $faker->word,
                'price' => $faker->randomFloat(2, 1, 1000),
                'category' => $faker->randomElement(['pharmacy', 'logistic', 'general']),
                'created_by' => 1, // Assuming user with ID 1 is the creator
                'updated_by' => null,
            ]);
        }
    }
}
