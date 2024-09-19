<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Carbon\Carbon;

class FiscalYearsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $currentYear = Carbon::now()->year;

        foreach (range(1, 5) as $index) {
            $startYear = $currentYear - 5 + $index; // Generate fiscal years for the last 5 years

            DB::table('fiscal_years')->insert([
                'company_id' => 1,
                'start_date' => Carbon::create($startYear, 1, 1)->format('Y-m-d'),
                'end_date' => Carbon::create($startYear, 12, 31)->format('Y-m-d'),
                'is_active' => $faker->boolean,
                'created_by' => 1, // Assuming user with ID 1 is the creator
                'updated_by' => null,
            ]);
        }
    }
}
