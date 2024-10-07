<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseSeeder extends Seeder
{
    public function run()
    {
        // Define keys for the expense data
        $keys = ['account_name', 'sub_account_name', 'account_code', 'account_type', 'is_debit', 'is_credit', 'bs_flag', 'pl_flag'];

        // Insert data into accounts table
        $expenses = [
            // Beban Operasional
            ['BEBAN OPERASIONAL MEDIS', 'Beban Farmasi', '511.00.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Beban Laboratorium', '512.00.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'PPN Instalasi Farmasi', '513.00.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Beban Gizi', '521.01.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'BHP Ruangan', '521.02.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Beban Kesejahteraan', '521.03.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Paket Pasien', '521.04.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Beban Cetakan', '521.05.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Beban Jasa Pelayanan', '522.00.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Beban Laboratorium', '523.00.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Beban Radiologi', '524.00.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Potongan Biaya Perawatan', '525.00.000', 6, 1, 0, 1, 0],
            ['BEBAN OPERASIONAL MEDIS', 'Beban Sewa Alat', '526.00.000', 6, 1, 0, 1, 0],

            // Beban Personalia
            ['BEBAN PERSONALIA', 'Beban Gaji', '611.00.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban Gaji, Upah & Tunjangan', '611.01.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban Tunjangan Pajak', '611.02.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Pesangon', '611.03.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'THR & SHU', '611.04.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban JKM & JKK', '611.05.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban JHT', '611.06.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban Takaful', '611.07.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban BPJS Kesehatan', '611.08.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban BPJS Dan Pensiun', '611.09.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban gaji Tidak langsung', '611.10.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban CSR BPJS Kesehatan', '611.11.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban Rekruitmen', '612.00.000', 6, 1, 0, 1, 0],
            ['BEBAN PERSONALIA', 'Beban Seragam', '613.00.000', 6, 1, 0, 1, 0],

            // Beban Administrasi
            ['BEBAN ADMINISTRASI', 'Beban Kesejahteraan Karyawan', '621.01.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Rapat', '621.02.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Pendidikan', '621.03.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Pelatihan/Diklat/Seminar', '621.04.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Konsultan', '621.05.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Pemasaran', '621.06.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Akreditasi', '621.07.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban ISO', '621.08.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Asuransi', '621.09.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Perjalanan Dinas', '621.10.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Administrasi Bank', '621.11.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Penyusutan', '621.12.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban ATK', '621.13.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Materai', '621.14.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Paket', '621.15.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Media Cetak', '621.16.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Jamuan Tamu', '621.17.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'PBB/Pajak Air/Uji Air Limbah', '621.18.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Perijinan & Adm', '621.19.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Iuran Keanggtaan & SIP', '621.20.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Penyusunan RAPB & Tarif', '621.21.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Peralatan', '621.22.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Instalasi', '621.23.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Kerugian Piutang', '621.24.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Denda Pajak', '621.25.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Audit', '621.26.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Amortisasi Akreditasi', '621.27.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Amortisasi Asset Lain', '621.28.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Pajak Daerah', '621.29.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Uji Fungsi Alat', '621.30.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Sewa', '621.31.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Transport laka Lantas', '621.32.000', 6, 1, 0, 1, 0],
            ['BEBAN ADMINISTRASI', 'Beban Digitalisasi Dokumen BPJ', '621.33.000', 6, 1, 0, 1, 0],

            // Beban Umum
            ['BEBAN UMUM', 'Beban Ambulance', '622.01.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Transport', '622.02.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Listrik', '622.03.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Telepon', '622.04.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Internet', '622.05.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Surat Kendaraan', '622.06.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Rumah Tangga', '622.07.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Laundry', '622.08.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Kebersihan', '622.09.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Pemeliharaan Gedung & Prasarana', '622.10.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Pemeliharaan Kendaraan', '622.11.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Pemeliharaan Alat Medis', '622.12.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Pemeliharaan Alat Non Medis & RT', '622.13.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Instalasi', '622.14.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Perawatan Jenazah', '622.15.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Solar Genset', '622.16.000', 6, 1, 0, 1, 0],
            ['BEBAN UMUM', 'Beban Bensin Incenerator', '622.17.000', 6, 1, 0, 1, 0],

            // Beban Diluar Usaha
            ['BEBAN DILUAR USAHA', 'Pajak Bunga Bank', '911.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Beban Bunga Angsuran', '912.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Infaq/Sumbangan', '913.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Share Diklat', '914.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Kontribusi Amal Usaha', '915.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Rugi Penjualan Aktiva', '916.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Sumbangan Dakwah PDM/MPKU', '917.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'CSR Kesehatan', '918.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Beban Caffe', '919.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Beban Kerugian Penghapusan Aset', '920.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Instruktur Senam', '921.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Sewa Gedung Olah Raga', '922.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Beban Kegiatan', '923.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Beban lain-lain', '924.00.000', 6, 1, 0, 1, 0],
            ['BEBAN DILUAR USAHA', 'Pembulatan', '925.00.000', 6, 1, 0, 1, 0],
        ];

        foreach ($expenses as $expense) {
            // Create associative array using the defined keys
            $data = array_combine($keys, $expense);
            DB::table('accounts')->insert(array_merge($data, [
                'is_active' => 1,
                'created_by' => 1, // Assuming user ID of the creator
                'updated_by' => null, // Null if not updated yet
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null, // Null if not deleted
            ]));
        }
    }
}
