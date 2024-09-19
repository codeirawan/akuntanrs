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
            CompanyTableSeeder::class,
            AccountsTableSeeder::class,
            ServicesTableSeeder::class,
            SpecialtiesTableSeeder::class,
            DoctorsTableSeeder::class,
            FiscalYearsTableSeeder::class,
            ItemsTableSeeder::class,
            PatientsTableSeeder::class,
            SuppliersTableSeeder::class,
            UnitsTableSeeder::class,
        ]);

    }
}
