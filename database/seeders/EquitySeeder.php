<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EquitySeeder extends Seeder
{
    public function run()
    {
        // Define keys for the account data
        $keys = ['account_name', 'sub_account_name', 'account_code', 'account_type', 'is_debit', 'is_credit', 'bs_flag', 'pl_flag'];

        // Insert data into accounts table
        $accounts = [
            ['MODAL', 'Modal', '310.00.000', 4, 0, 1, 1, 0],
            ['MODAL', 'Modal Disetor', '311.00.000', 4, 0, 1, 1, 0],
            ['MODAL', 'Modal Sumbangan', '312.00.000', 4, 0, 1, 1, 0],
            ['MODAL', 'Laba ditahan', '380.00.000', 4, 0, 1, 1, 0],
            ['MODAL', 'SHU Tahun Berjalan', '390.00.000', 4, 0, 1, 1, 0],
            ['MODAL', 'Historical Balancing', '399.99.000', 4, 0, 1, 1, 0],
        ];

        foreach ($accounts as $account) {
            // Create associative array using the defined keys
            $data = array_combine($keys, $account);
            DB::table('accounts')->insert(array_merge($data, [
                'is_active' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]));
        }
    }
}
