<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AccountsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $accountTypes = ['asset', 'liability', 'equity', 'income', 'expense'];
        $dcTypes = ['d', 'c'];

        foreach (range(1, 20) as $index) {
            DB::table('accounts')->insert([
                'account_name' => $faker->word . ' Account',
                'account_code' => $faker->unique()->word,
                'account_type' => $faker->randomElement($accountTypes),
                'dc_type' => $faker->randomElement($dcTypes),
                'opening_balance' => $faker->randomFloat(2, 0, 10000),
                'opening_balance_date' => $faker->date,
                'is_active' => $faker->boolean,
                'created_by' => 1, // Assuming user with ID 1 is the creator
                'updated_by' => null,
            ]);
        }
    }
}
