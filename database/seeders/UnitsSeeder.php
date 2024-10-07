<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    public function run()
    {
        $units = [
            'Klinik Umum',
            'Klinik Gigi',
            'Klinik Obstetri & Gynokologi',
            'Klinik Bedah Umum',
            'Klinik Bedah Ortopedy',
            'Klinik Penyakit Dalam',
            'Klinik Anak',
            'Klinik Syaraf',
            'Klinik THT',
            'Klinik MCU',
            'Klinik Tumbuh Kembang Anak',
            'Klinik Mata',
            'Klinik Jiwa',
            'Klinik Jantung',
            'Klinik Urologi',
            'Klinik Paru',
            'Klinik Baitussalam',
            'Klinik Geriatri',
            'Klinik Vaksin',
            'Klinik Bedah Syaraf'
        ];

        foreach ($units as $unit) {
            DB::table('units')->insert([
                'unit_name' => $unit,
                'created_by' => 1, // Assuming user with ID 1 is the creator
                'updated_by' => null,
            ]);
        }
    }
}
