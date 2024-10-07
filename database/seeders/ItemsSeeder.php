<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsSeeder extends Seeder
{
    public function run()
    {
        $items = [
            ['code' => 'MED001', 'name' => 'Paracetamol', 'unit' => 'tablet', 'price' => 5000, 'category' => 1, 'created_by' => 1, 'updated_by' => null], // pharmacy
            ['code' => 'MED002', 'name' => 'Ibuprofen', 'unit' => 'tablet', 'price' => 8000, 'category' => 1, 'created_by' => 1, 'updated_by' => null], // pharmacy
            ['code' => 'MED003', 'name' => 'Amoxicillin', 'unit' => 'capsule', 'price' => 15000, 'category' => 1, 'created_by' => 1, 'updated_by' => null], // pharmacy
            ['code' => 'LOG001', 'name' => 'Sarung Tangan Medis', 'unit' => 'box', 'price' => 25000, 'category' => 2, 'created_by' => 1, 'updated_by' => null], // logistic
            ['code' => 'LOG002', 'name' => 'Masker Bedah', 'unit' => 'pack', 'price' => 20000, 'category' => 2, 'created_by' => 1, 'updated_by' => null], // logistic
            ['code' => 'GNR001', 'name' => 'Alat Ukur Tekanan Darah', 'unit' => 'unit', 'price' => 300000, 'category' => 3, 'created_by' => 1, 'updated_by' => null], // general
            ['code' => 'GNR002', 'name' => 'Oksigen Silinder', 'unit' => 'unit', 'price' => 500000, 'category' => 3, 'created_by' => 1, 'updated_by' => null], // general
            ['code' => 'LOG003', 'name' => 'Alat P3K', 'unit' => 'set', 'price' => 75000, 'category' => 2, 'created_by' => 1, 'updated_by' => null], // logistic
            ['code' => 'MED004', 'name' => 'Cetirizine', 'unit' => 'tablet', 'price' => 10000, 'category' => 1, 'created_by' => 1, 'updated_by' => null], // pharmacy
            ['code' => 'MED005', 'name' => 'Loperamide', 'unit' => 'capsule', 'price' => 12000, 'category' => 1, 'created_by' => 1, 'updated_by' => null], // pharmacy
            ['code' => 'GNR003', 'name' => 'Alat Inhalasi', 'unit' => 'unit', 'price' => 450000, 'category' => 3, 'created_by' => 1, 'updated_by' => null], // general
            ['code' => 'LOG004', 'name' => 'Tenda Medis', 'unit' => 'unit', 'price' => 800000, 'category' => 2, 'created_by' => 1, 'updated_by' => null], // logistic
            ['code' => 'LOG005', 'name' => 'Suntikan', 'unit' => 'box', 'price' => 15000, 'category' => 2, 'created_by' => 1, 'updated_by' => null], // logistic
            ['code' => 'LOG006', 'name' => 'Baju Operasi', 'unit' => 'set', 'price' => 50000, 'category' => 2, 'created_by' => 1, 'updated_by' => null], // logistic
            ['code' => 'LOG007', 'name' => 'Tissue Medis', 'unit' => 'pack', 'price' => 30000, 'category' => 2, 'created_by' => 1, 'updated_by' => null], // logistic
        ];

        DB::table('items')->insert($items);
    }
}
