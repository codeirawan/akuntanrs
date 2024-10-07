<?php

namespace Database\Seeders;

use App\User;
use Carbon\Carbon;
use App\Models\Master\Account;
use Illuminate\Database\Seeder;
use App\Models\Transaction\JournalEntry;

class JournalEntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ensure that users and accounts already exist in your system.
        $users = User::all();
        $accounts = Account::all();

        // If no users or accounts exist, don't proceed
        if ($users->isEmpty() || $accounts->isEmpty()) {
            $this->command->info('No users or accounts found. Please seed users and accounts first.');
            return;
        }

        // Create 10 Journal Entries
        foreach (range(1, 10) as $index) {
            // Get current year and month
            $currentDate = Carbon::now();
            $year = $currentDate->year;
            $month = $currentDate->format('m');  // Two-digit month

            // Get the latest journal entry for the current year and month
            $latestJournalEntry = JournalEntry::whereYear('journal_date', $year)
                ->whereMonth('journal_date', $month)
                ->orderBy('voucher_code', 'desc')
                ->first();

            // Determine the next increment number (XXX part)
            if ($latestJournalEntry) {
                // Extract the last 3 digits from the latest voucher_code and increment it
                $lastIncrement = (int) substr($latestJournalEntry->voucher_code, -3);
                $nextIncrement = str_pad($lastIncrement + 1, 3, '0', STR_PAD_LEFT);  // Increment and pad to 3 digits
            } else {
                // Start with 001 if no previous entries exist for the current month
                $nextIncrement = '001';
            }

            // Generate voucher_code in the format JV-YYYYMM-XXX
            $voucherCode = 'JV-' . $year . $month . '-' . $nextIncrement;

            $journalDate = now()->subDays(rand(0, 365))->format('Y-m-d');
            $createdBy = $users->random()->id;

            // Creating multiple debit and credit entries for the same voucher
            $journalEntries = [
                [
                    'account_id' => $accounts->random()->id,
                    'journal_date' => $journalDate,
                    'voucher_code' => $voucherCode,
                    'debit' => rand(100000, 1000000),
                    'credit' => 0,
                    'note' => 'Sample debit transaction',
                    'created_by' => $createdBy,
                    'updated_by' => null,
                ],
                [
                    'account_id' => $accounts->random()->id,
                    'journal_date' => $journalDate,
                    'voucher_code' => $voucherCode,
                    'debit' => 0,
                    'credit' => rand(100000, 1000000),
                    'note' => 'Sample credit transaction',
                    'created_by' => $createdBy,
                    'updated_by' => null,
                ],
            ];

            // Insert journal entries into the database
            foreach ($journalEntries as $entry) {
                JournalEntry::create($entry);
            }
        }

        $this->command->info('Journal Entries with formatted voucher codes seeded successfully!');
    }
}