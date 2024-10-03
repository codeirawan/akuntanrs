<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['service_code' => 'CONS001', 'service_name' => 'Konsultasi - Dokter Umum', 'price' => 50000, 'description' => 'Konsultasi kesehatan umum', 'service_type' => 1, 'created_by' => 1],
            ['service_code' => 'CONS002', 'service_name' => 'Konsultasi - Kardiolog', 'price' => 150000, 'description' => 'Konsultasi untuk masalah jantung', 'service_type' => 1, 'created_by' => 1],
            ['service_code' => 'CONS003', 'service_name' => 'Konsultasi - Dokter Anak', 'price' => 120000, 'description' => 'Konsultasi untuk anak-anak', 'service_type' => 1, 'created_by' => 1],
            ['service_code' => 'SURG001', 'service_name' => 'Bedah - Apendektomi', 'price' => 5000000, 'description' => 'Bedah untuk mengangkat usus buntu', 'service_type' => 2, 'created_by' => 1],
            ['service_code' => 'SURG002', 'service_name' => 'Bedah - Katarak', 'price' => 3000000, 'description' => 'Bedah untuk mengangkat katarak', 'service_type' => 2, 'created_by' => 1],
            ['service_code' => 'SURG003', 'service_name' => 'Bedah - Perbaikan Hernia', 'price' => 4000000, 'description' => 'Bedah perbaikan hernia', 'service_type' => 2, 'created_by' => 1],
            ['service_code' => 'DIAG001', 'service_name' => 'Diagnostik - Pemindaian MRI', 'price' => 2000000, 'description' => 'Pemindaian Pencitraan Resonansi Magnetik (MRI)', 'service_type' => 3, 'created_by' => 1],
            ['service_code' => 'DIAG002', 'service_name' => 'Diagnostik - X-Ray', 'price' => 150000, 'description' => 'Pemindaian gambar X-Ray', 'service_type' => 3, 'created_by' => 1],
            ['service_code' => 'DIAG003', 'service_name' => 'Diagnostik - Ultrasonografi', 'price' => 100000, 'description' => 'Pencitraan ultrasonografi', 'service_type' => 3, 'created_by' => 1],
            ['service_code' => 'INPT001', 'service_name' => 'Rawat Inap - Kamar Umum', 'price' => 750000, 'description' => 'Akomodasi di kamar umum', 'service_type' => 4, 'created_by' => 1],
            ['service_code' => 'INPT002', 'service_name' => 'Rawat Inap - Kamar VIP', 'price' => 2500000, 'description' => 'Akomodasi di kamar VIP dengan fasilitas pribadi', 'service_type' => 4, 'created_by' => 1],
            ['service_code' => 'INPT003', 'service_name' => 'Rawat Inap - ICU', 'price' => 5000000, 'description' => 'Akomodasi di Unit Perawatan Intensif (ICU)', 'service_type' => 4, 'created_by' => 1],
            ['service_code' => 'OUTP001', 'service_name' => 'Rawat Jalan - Tes Darah', 'price' => 200000, 'description' => 'Tes darah rutin untuk berbagai kondisi', 'service_type' => 5, 'created_by' => 1],
            ['service_code' => 'OUTP002', 'service_name' => 'Rawat Jalan - Fisioterapi', 'price' => 300000, 'description' => 'Sesi fisioterapi untuk rehabilitasi', 'service_type' => 5, 'created_by' => 1],
            ['service_code' => 'OUTP003', 'service_name' => 'Rawat Jalan - Perban Luka', 'price' => 100000, 'description' => 'Perban dan perawatan luka', 'service_type' => 5, 'created_by' => 1],
            ['service_code' => 'CONS004', 'service_name' => 'Konsultasi - Neurolog', 'price' => 200000, 'description' => 'Konsultasi untuk masalah otak dan sistem saraf', 'service_type' => 1, 'created_by' => 1],
            ['service_code' => 'SURG004', 'service_name' => 'Bedah - Pengangkatan Kandung Empedu', 'price' => 3500000, 'description' => 'Bedah untuk mengangkat kandung empedu', 'service_type' => 2, 'created_by' => 1],
            ['service_code' => 'DIAG004', 'service_name' => 'Diagnostik - Pemindaian CT', 'price' => 1800000, 'description' => 'Pemindaian Tomografi Terkomputasi (CT)', 'service_type' => 3, 'created_by' => 1],
            ['service_code' => 'INPT004', 'service_name' => 'Rawat Inap - Kamar Pribadi', 'price' => 1500000, 'description' => 'Kamar pribadi untuk perawatan inap', 'service_type' => 4, 'created_by' => 1],
            ['service_code' => 'OUTP004', 'service_name' => 'Rawat Jalan - Vaksinasi', 'price' => 250000, 'description' => 'Vaksinasi untuk berbagai penyakit', 'service_type' => 5, 'created_by' => 1],
        ];

        DB::table('services')->insert($services);
    }
}
