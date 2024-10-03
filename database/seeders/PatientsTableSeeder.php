<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Set locale to Indonesian

        foreach (range(1, 20) as $index) {
            DB::table('patients')->insert([
                'name' => $faker->name,
                'nik' => $faker->unique()->numerify('########################'), // 32 digit NIK
                'dob' => $faker->date('Y-m-d', 'now'), // Format the date
                'gender' => $faker->randomElement([0, 1]), // '0' for female, '1' for male
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'insurance_name' => $faker->randomElement(['BPJS Kesehatan', 'Asuransi Jiwa Manulife', 'Asuransi Allianz', 'Asuransi BRI Life']), // Common Indonesian insurance companies
                'insurance_no' => $faker->unique()->numerify('############'), // 12-digit insurance number
                'address' => $faker->address,
                'note' => $faker->sentence,
                'created_by' => 1,
                'updated_by' => null,
            ]);
        }
    }
}
