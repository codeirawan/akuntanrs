<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtiesSeeder extends Seeder
{
    public function run()
    {
        $specialties = [
            'Kedokteran Umum',
            'Kedokteran Gigi',
            'Obstetri & Ginekologi',
            'Bedah Umum',
            'Bedah Ortopedi',
            'Penyakit Dalam',
            'Kedokteran Anak',
            'Syaraf',
            'THT (Telinga, Hidung, Tenggorokan)',
            'Kesehatan Kerja',
            'Tumbuh Kembang Anak',
            'Mata',
            'Jiwa',
            'Jantung',
            'Urologi',
            'Paru',
            'Geriatri',
            'Vaksinasi',
            'Bedah Syaraf',
            'Gastroenterologi',
            'Hematologi',
            'Kardiologi',
            'Nephrologi',
            'Onkologi',
            'Pulmonologi',
            'Radiologi',
            'Reumatologi',
            'Psikiatri',
            'Anestesiologi'
        ];

        foreach ($specialties as $specialty) {
            DB::table('specialties')->insert([
                'name' => $specialty,
                'description' => 'Spesialisasi dalam ' . $specialty,
                'created_by' => 1, // Assuming user with ID 1 is the creator
                'updated_by' => null,
            ]);
        }
    }
}
