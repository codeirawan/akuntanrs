<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReceiptServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed 10 random receipt service records
        for ($i = 0; $i < 10; $i++) {
            DB::table('receipt_services')->insert([
                'receipt_id' => rand(1, 10), // Assuming there are receipt records with IDs 1 to 10
                'service_id' => rand(1, 10), // Assuming there are service records with IDs 1 to 10
                'unit_id' => rand(1, 10), // Assuming there are service records with IDs 1 to 10
                'doctor_id' => rand(1, 10), // Assuming there are service records with IDs 1 to 10
                'price' => rand(1000, 10000) / 100, // Random amount between 10.00 and 100.00
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
