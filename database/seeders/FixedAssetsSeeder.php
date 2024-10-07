<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixedAssetsSeeder extends Seeder
{
    public function run()
    {
        // Define keys for the account data
        $keys = ['account_name', 'sub_account_name', 'account_code', 'account_type', 'is_debit', 'is_credit', 'bs_flag', 'pl_flag'];

        // Insert data into accounts table
        $accounts = [
            ['ASET TETAP', 'Tanah', '131.10.000', 2, 1, 0, 1, 0],
            ['ASET TETAP', 'Bangunan', '132.10.000', 2, 1, 0, 1, 0],
            ['ASET TETAP', 'Akm. Peny. Bangunan', '132.20.000', 2, 0, 1, 1, 0],
            ['ASET TETAP', 'Kendaraan', '133.10.000', 2, 1, 0, 1, 0],
            ['ASET TETAP', 'Akm. Peny. Kendaraan', '133.20.000', 2, 0, 1, 1, 0],
            ['ASET TETAP', 'Peralatan Medis', '134.10.000', 2, 1, 0, 1, 0],
            ['ASET TETAP', 'Akm. Peny. Perlatan Medis', '134.20.000', 2, 0, 1, 1, 0],
            ['ASET TETAP', 'Peralatan Non Medis', '135.10.000', 2, 1, 0, 1, 0],
            ['ASET TETAP', 'Akm. Peny. Peralatan Non Medis', '135.20.000', 2, 0, 1, 1, 0],
            ['ASET LAIN-LAIN', 'Aktiva Lain-Lain', '140.00.000', 2, 1, 0, 1, 0],
            ['ASET LAIN-LAIN', 'Akm. Peny. Aktiva Lain-Lain', '140.10.000', 2, 0, 1, 1, 0],
            ['ASET LAIN-LAIN', 'Aset Lain-lain', '146.00.000', 2, 1, 0, 1, 0],
            ['UANG MUKA BIAYA', 'Uang Muka Biaya', '141.00.000', 2, 1, 0, 1, 0],
            ['PPN KMS', 'PPN KMS', '142.00.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Gudang Farmasi & Sofa', '145.01.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Farmasi Rajal', '145.02.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP IBS', '145.03.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Gizi', '145.04.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Guest House', '145.05.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Ipal', '145.06.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Loundry', '145.07.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Ruang Jenazah', '145.08.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Koperasi', '145.09.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP LT 9', '145.10.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Parkir', '145.11.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Poli', '145.12.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Gudang IPRS', '145.13.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Ground Tank', '145.14.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Rumah Septi', '145.15.000', 2, 1, 0, 1, 0],
            ['BANGUNAN DALAM PROSES', 'BDP Rumah Suhadi', '145.16.000', 2, 1, 0, 1, 0],
            ['AKREDITASI', 'Akreditasi', '147.00.000', 2, 1, 1, 1, 0],
            ['DEPOSITO CT SCAN', 'Deposit CT Scan', '148.00.000', 2, 1, 1, 1, 0],
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
