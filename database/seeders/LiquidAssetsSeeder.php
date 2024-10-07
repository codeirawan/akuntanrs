<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LiquidAssetsSeeder extends Seeder
{
    public function run()
    {
        // Define keys for the account data
        $keys = ['account_name', 'sub_account_name', 'account_code', 'account_type', 'is_debit', 'is_credit', 'bs_flag', 'pl_flag'];

        // Insert data into accounts table
        $accounts = [
            // Kas
            ['KAS', 'Kas', '111.01.000', 1, 1, 0, 1, 0],

            // Bank Accounts
            ['BANK', 'BPD Giro 10118002812', '111.03.000', 1, 1, 0, 1, 0],
            ['BANK', 'Mandiri Tab 1360006315581', '111.04.000', 1, 1, 0, 1, 0],
            ['BANK', 'BSI Giro 4560001692', '111.05.000', 1, 1, 0, 1, 0],
            ['BANK', 'BSI Tab-3 7025150591', '111.06.000', 1, 1, 0, 1, 0],
            ['BANK', 'BNI Syr Tab 0177171791', '111.07.000', 1, 1, 0, 1, 0],
            ['BANK', 'BNI Syr Giro 0177021462', '111.08.000', 1, 1, 0, 1, 0],
            ['BANK', 'Artha Surya Barokah 1022200018', '111.09.000', 1, 1, 0, 1, 0],
            ['BANK', 'Muamalat Tab 5040008933', '111.10.000', 1, 1, 0, 1, 0],
            ['BANK', 'Muamalat Tab 5040009455', '111.11.000', 1, 1, 0, 1, 0],
            ['BANK', 'Kospin 101070000356', '111.12.000', 1, 1, 0, 1, 0],
            ['BANK', 'Kospin 2019010002553', '111.13.000', 1, 1, 0, 1, 0],
            ['BANK', 'BSI Tabungan-2 1023266737', '111.14.000', 1, 1, 0, 1, 0],
            ['BANK', 'BPD Syariah 5031001489', '111.15.000', 1, 1, 0, 1, 0],
            ['BANK', 'BRI 003401001156300', '111.16.000', 1, 1, 0, 1, 0],
            ['BANK', 'BPD Syariah 5031001845', '111.17.000', 1, 1, 0, 1, 0],
            ['BANK', 'BNI 2946418702', '111.18.000', 1, 1, 0, 1, 0],
            ['BANK', 'BSI Tabungan-1 1251811886', '111.19.000', 1, 1, 0, 1, 0],
            ['BANK', 'Kuncup Melati', '111.20.000', 1, 1, 0, 1, 0],
            ['BANK', 'BPR Bangun Drajat Warga', '111.21.000', 1, 1, 0, 1, 0],
            ['BANK', 'BDW-5012050830', '111.22.000', 1, 1, 0, 1, 0],
            ['BANK', 'Deposito BRI Syariah', '111.25.000', 1, 1, 0, 1, 0],
            ['BANK', 'Deposito Kuncup Melati', '111.26.000', 1, 1, 0, 1, 0],
            ['BANK', 'Muamalat Giro 5040016513', '111.27.000', 1, 1, 0, 1, 0],
            ['BANK', 'BRI Tab 003401002183562', '111.28.000', 1, 1, 0, 1, 0],

            // Piutang Usaha
            ['PIUTANG USAHA', 'Piutang Pasien Umum', '112.01.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Inheakth', '112.02.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang BPJS PBI', '112.03.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang BPJS Non PBI', '112.04.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Jasa Raharja', '112.05.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass PT KAI', '112.06.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass PT. Telkom', '112.07.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass PT. PLN', '112.08.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass PT. Garda Medika', '112.09.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass PT. Multi Artha G', '112.10.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass PT. Sinar Mas', '112.11.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang TB Dot Aisyah', '112.12.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass PT. Admedika', '112.13.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass CAR', '112.14.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass BNI Life', '112.15.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass Jasindo', '112.16.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Jampersal', '112.17.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Klinik Surya Medika', '112.18.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang RSI II Truko', '112.19.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Karyawan Koperasi', '112.20.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Dokter Mitra', '112.21.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Karyawan RI', '112.22.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Karyawan RJ', '112.23.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Instalasi Gizi', '112.24.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Covid 19', '112.25.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Jamkesda', '112.26.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang BPJS Ketenagakarjaan', '112.27.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang PT. Waskita Karya', '112.28.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang BNI', '112.29.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Cadangan Penghapusan Piutang', '112.30.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass Owlexa', '112.31.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang PT. KAI', '112.32.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass Askes', '112.33.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHA', 'Piutang Ass PT. Asuransi', '112.34.000', 1, 1, 0, 1, 0],
            ['PIUTANG USAHAA', 'Piutang Pasien Asuransi', '112.35.000', 1, 1, 0, 1, 0],

            // Piutang Lain-lain
            ['PIUTANG LAIN-LAIN', 'Piutang Karyawan', '113.01.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Yayasan', '113.02.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Pihak III', '113.03.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Renov. Masjid', '113.04.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Ar Rahmah', '113.05.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang RSI II Truko', '113.06.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Akper Kendal/Umkaba', '113.07.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang dr Mitra', '113.08.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Klinik Surya Medika', '113.09.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Karyawan Pph 21', '113.10.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang RS PKU Aisyiyah Kendal', '113.11.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Lazizmu', '113.12.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang D1 Kemuhamadiyahan', '113.13.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang RS Darul Istiqomah', '113.14.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang RSI Boja', '113.15.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang KBIH Ar Rahmah', '113.16.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Inst. Covid', '113.17.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Kospin Kuncup Melati', '113.18.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang Vaksin Covid', '113.19.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang RSI II Patean Kendal', '113.20.000', 1, 1, 0, 1, 0],
            ['PIUTANG LAIN-LAIN', 'Piutang MI Muhammadiyah Caruban', '113.21.000', 1, 1, 0, 1, 0],

            // Persediaan
            ['PERSEDIAAN', 'Persediaan Farmasi', '114.01.000', 1, 1, 0, 1, 0],
            ['PERSEDIAAN', 'Persediaan Laborat', '114.02.000', 1, 1, 0, 1, 0],
            ['PERSEDIAAN', 'Persediaan ATK', '115.01.000', 1, 1, 0, 1, 0],
            ['PERSEDIAAN', 'Persediaan Materai', '115.02.000', 1, 1, 0, 1, 0],
            ['PERSEDIAAN', 'Persediaan Cetakan', '115.03.000', 1, 1, 0, 1, 0],
            ['PERSEDIAAN', 'Persediaan Paket Pasien', '115.04.000', 1, 1, 0, 1, 0],
            ['PERSEDIAAN', 'Persediaan Rumah Tangga', '115.05.000', 1, 1, 0, 1, 0],

            // Bon Sementara
            ['BON SEMENTRA', 'Bon Sementara Umum', '116.01.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'Bon Tanti (Pembangunan)', '116.02.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Finising bangunan Lt 1', '116.03.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Laborat', '116.04.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Kendaraan', '116.05.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Tim Akreditasi', '116.06.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Panita Milad', '116.07.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB CT Scan', '116.08.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Binroh', '116.09.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Panitia Ramadhan', '116.10.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Gizi', '116.11.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Humas', '116.12.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB SDI', '116.13.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Farmasi', '116.14.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB CS', '116.15.000', 1, 1, 0, 1, 0],
            ['BON SEMENTRA', 'KB Caffe', '116.16.000', 1, 1, 0, 1, 0],

            // Pajak Dibayar Dimuka
            ['PAJAK DIBAYAR DIMUKA', 'Pph Psl 21', '117.01.000', 1, 1, 0, 1, 0],
            ['PAJAK DIBAYAR DIMUKA', 'PPh Psl 25', '117.02.000', 1, 1, 0, 1, 0],
            ['PAJAK DIBAYAR DIMUKA', 'PPN', '117.03.000', 1, 1, 0, 1, 0],
            ['PAJAK DIBAYAR DIMUKA', 'PPh Psl 23', '117.04.000', 1, 1, 0, 1, 0],

            // Asuransi Dibayar Dimuka
            ['ASURANSI DIBAYAR DIMUKA', 'Asuransi', '118.01.000', 1, 1, 0, 1, 0],

            // Investasi Jangka Panjang
            ['INVESTASI JANGKA PANJANG', 'Saham BPR Artha Surya', '121.00.000', 1, 1, 0, 1, 0],
            ['INVESTASI JANGKA PANJANG', 'Koperasi Surya Medika Timur', '122.00.000', 1, 1, 0, 1, 0],
            ['INVESTASI JANGKA PANJANG', 'Koperasi Surya Medika Tengah', '123.00.000', 1, 1, 0, 1, 0],
            ['INVESTASI JANGKA PANJANG', 'Saham Toko Minasari', '124.00.000', 1, 1, 0, 1, 0],
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
