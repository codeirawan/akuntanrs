<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReceiptItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed 10 random receipt item records
        for ($i = 0; $i < 10; $i++) {
            DB::table('receipt_items')->insert([
                'receipt_id' => rand(1, 10), // Ensure these IDs exist
                'item_id' => rand(1, 10),    // Ensure these IDs exist
                'item_code' => 'ITEM-' . Str::random(5), // Example item code
                'item_name' => 'Item ' . Str::random(5), // Example item name
                'item_unit' => 'pcs', // Example unit
                'item_qty' => rand(1, 100), // Random quantity
                'unit_price' => rand(1000, 5000) / 100, // Random price
                'total_price' => rand(1000, 5000) / 100, // Random total price
                'item_type' => rand(1, 3), // Random item type
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
