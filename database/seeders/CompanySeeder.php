<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
        DB::table('company')->insert([
            'name' => 'Sample Company',
            'address' => '123 Sample Street, Sample City',
            'phone' => '+62 123 456 7890',
            'email' => 'info@samplecompany.com',
            'created_by' => 1,
            'updated_by' => null,
        ]);
    }
}
