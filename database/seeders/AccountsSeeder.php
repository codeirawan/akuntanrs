<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountsSeeder extends Seeder
{
    public function run()
    {
        DB::table('accounts')->insert([
            [
                'account_name' => 'Cash',
                'account_code' => '1001',
                'account_type' => 1, // asset
                'dc_type' => 1, // debit
                'opening_balance' => 10000.00,
                'opening_balance_date' => '2024-01-01',
                'is_active' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'account_name' => 'Accounts Receivable',
                'account_code' => '1002',
                'account_type' => 1, // asset
                'dc_type' => 1, // debit
                'opening_balance' => 5000.00,
                'opening_balance_date' => '2024-01-01',
                'is_active' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'account_name' => 'Inventory',
                'account_code' => '1003',
                'account_type' => 1, // asset
                'dc_type' => 1, // debit
                'opening_balance' => 20000.00,
                'opening_balance_date' => '2024-01-01',
                'is_active' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'account_name' => 'Accounts Payable',
                'account_code' => '2001',
                'account_type' => 2, // liability
                'dc_type' => 2, // credit
                'opening_balance' => 7000.00,
                'opening_balance_date' => '2024-01-01',
                'is_active' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'account_name' => 'Sales Revenue',
                'account_code' => '4001',
                'account_type' => 4, // income
                'dc_type' => 2, // credit
                'opening_balance' => 0.00,
                'opening_balance_date' => '2024-01-01',
                'is_active' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'account_name' => 'Expense Account',
                'account_code' => '5001',
                'account_type' => 5, // expense
                'dc_type' => 1, // debit
                'opening_balance' => 0.00,
                'opening_balance_date' => '2024-01-01',
                'is_active' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
