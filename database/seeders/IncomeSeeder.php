<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeSeeder extends Seeder
{
    public function run()
    {
        // Define keys for the account data
        $keys = ['account_name', 'sub_account_name', 'account_code', 'account_type', 'is_debit', 'is_credit', 'bs_flag', 'pl_flag'];

        // Insert data into accounts table
        $accounts = [
            // Pendapatan Operasional
            ['PENDAPATAN OPERASIONAL RI', 'Pendapatan Akomodasi Kamar', '411.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RI', 'Pendapatan Bedah Sentral', '412.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RI', 'Pendapatan Konsultasi', '413.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RI', 'Pendapatan Tindakan Partus', '414.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RI', 'Pendapatan Tindakan Medis Ruangan', '415.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RI', 'Pendapatan Visit Dokter', '416.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RI', 'Pendapatan Laboratorium RI', '417.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RI', 'Pendapatan Farmasi RI', '418.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RI', 'Pendapatan Radiologi RI', '419.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RJ', 'Pendapatan Poliklinik', '421.01.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RJ', 'Pendapatan Laboratorium RJ', '422.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL RJ', 'Pendapatan Radiologi', '423.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan Administrasi RI', '431.01.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan Administrasi RJ', '431.02.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan Materai', '431.03.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan Adm Resume Medis', '431.04.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan Ambulance', '432.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan Perawatan Jenazah', '433.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan Tes Kesehatan', '434.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan BHP', '435.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan BNN', '436.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan Denda BPJS', '440.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan Selisih Covid 19', '450.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN OPERASIONAL LAIN', 'Pendapatan BPJS', '460.00.000', 5, 0, 1, 0, 1],

            // Pendapatan Diluar Usaha
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. Bunga Bank', '811.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendapatan Parkir', '812.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. Telepon', '813.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. Sewa', '814.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. Kapitasi', '815.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. Diklat', '816.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. Penjualan Sampah', '817.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. DP Discount', '818.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. Infaq/Sumbangan', '819.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt Lain-lain', '821.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pembulatan', '822.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. Laba Penjualan Aktiva', '823.00.000', 5, 0, 1, 0, 1],
            ['PENDAPATAN DILUAR USAHA', 'Pendpt. Caffe', '824.00.000', 5, 0, 1, 0, 1],
        ];

        foreach ($accounts as $account) {
            // Create associative array using the defined keys
            $data = array_combine($keys, $account);
            DB::table('accounts')->insert(array_merge($data, [
                'is_active' => 1,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ]));
        }
    }
}
