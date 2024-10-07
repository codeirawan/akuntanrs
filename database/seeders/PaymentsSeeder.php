<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed 10 random payment records
        for ($i = 0; $i < 10; $i++) {
            DB::table('payments')->insert([
                'payment_code' =>  'PY-' . Carbon::now()->format('Ymd') . '-' . strtoupper(Str::random(4)),
                'payment_date' => Carbon::now()->subDays(rand(1, 30)), // Random dates within the last 30 days
                'payment_type' => rand(1, 4), // Randomly select between 1 (Cash), 2 (Non Cash), 3 (Petty Cash), 4 (Receivables)
                'payment_status' => rand(1, 3), // Randomly select between 1 (Paid), 2 (Unpaid), 3 (Pending)
                'receipt_id' => rand(1, 10), // Assuming receipts with IDs from 1 to 10 exist
                'doctor_id' => rand(1, 10), // Assuming doctors with IDs from 1 to 10 exist
                'supplier_id' => rand(1, 10), // Assuming suppliers with IDs from 1 to 10 exist
                'account_id' => rand(1, 5), // Assuming accounts with IDs from 1 to 10 exist
                'amount' => round(rand(1000, 5000) / 100, 2), // Random amount between 10.00 and 50.00
                'note' => 'Payment for transaction ' . ($i + 1),
                'created_by' => 1, // Assuming user with ID 1 exists
                'updated_by' => null, // No updates yet
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
