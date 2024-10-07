<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LaratrustSeeder::class,
            CompanySeeder::class,
            AccountsSeeder::class,
            ServicesSeeder::class,
            SpecialtiesSeeder::class,
            DoctorsSeeder::class,
            FiscalYearsSeeder::class,
            ItemsSeeder::class,
            PatientsSeeder::class,
            SuppliersSeeder::class,
            UnitsSeeder::class,
            ReceiptsSeeder::class,
            ReceiptServicesSeeder::class,
            ReceiptItemsSeeder::class,
            PaymentsSeeder::class,
            PaymentItemsSeeder::class,
            JournalEntrySeeder::class,
        ]);

    }
}
