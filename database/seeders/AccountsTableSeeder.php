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

        // More realistic account names
        $accountNames = [
            'Cash',
            'Accounts Receivable',
            'Inventory',
            'Prepaid Expenses',
            'Accounts Payable',
            'Accrued Liabilities',
            'Common Stock',
            'Retained Earnings',
            'Sales Revenue',
            'Cost of Goods Sold',
            'Operating Expenses',
            'Depreciation Expense',
            'Interest Expense',
            'Taxes Payable',
            'Long-term Debt',
            'Dividends Payable'
        ];

        foreach (range(1, 16) as $index) {
            DB::table('accounts')->insert([
                'account_name' => $faker->randomElement($accountNames),
                'account_code' => strtoupper($faker->unique()->lexify('??-???')),
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
