Pengelompokan yang Anda buat terlihat lebih terstruktur dan jelas berdasarkan fungsi utama dari setiap entitas. Berikut adalah beberapa penjelasan terkait pengelompokan tersebut:

### 1. **Transaction**

   Pengelompokan model dan controller di bawah namespace `Transaction` meliputi berbagai jenis transaksi yang dilakukan oleh perusahaan, baik itu transaksi medis, bank, atau kasir.

- **MedicalService**: Transaksi yang berhubungan dengan layanan medis kepada pasien.
- **CashBank**: Transaksi yang mencatat arus kas masuk dan keluar dari bank.
- **JournalEntry**: Pencatatan transaksi yang berkaitan dengan jurnal akuntansi.
- **CashierTransaction**: Transaksi yang terjadi di kasir.
- **CashierReceivable**: Pencatatan piutang yang ditangani melalui kasir.

  Pengelompokan ini membantu memisahkan transaksi operasional sehari-hari dengan transaksi yang lebih berfokus pada pelaporan atau pengelolaan aset.

### 2. **Purchase**

   **Pharmacy**, **Logistic**, dan **General** adalah kategori pembelian yang berbeda, sehingga pengelompokan ini lebih cocok di bawah namespace `Purchase` untuk memudahkan pengelolaan barang masuk berdasarkan jenisnya.

- **PharmacyPurchase**, **LogisticPurchase**, dan **GeneralPurchase**: Masing-masing bertanggung jawab untuk mencatat pembelian sesuai jenis item yang dibeli.
- **Usage** dan **Cogs** (Harga Pokok Penjualan) digunakan untuk mencatat pemakaian barang serta perhitungan harga pokok.

### 3. **Report**

   Namespace `Report` lebih cocok untuk pengelompokan yang terkait dengan pelaporan keuangan, seperti **AccountsPayable**, **AccountsReceivable**, **GeneralJournal**, **GeneralLedger**, **IncomeStatement**, dan **BalanceSheet**.

- **AccountsPayable** dan **AccountsReceivable**: Mewakili pelaporan hutang dan piutang perusahaan.
- **GeneralJournal** dan **GeneralLedger**: Mencakup catatan umum dalam buku besar.
- **IncomeStatement** dan **BalanceSheet**: Digunakan untuk menyusun laporan laba rugi dan neraca keuangan.

### 4. **Asset**

   Pengelompokan **FixedAsset** di bawah namespace `Asset` adalah untuk memisahkan pencatatan dan pengelolaan aset tetap dari transaksi keuangan lainnya. Aset tetap memerlukan perhatian khusus terkait depresiasi, pengelolaan umur aset, serta pengaruhnya terhadap laporan keuangan jangka panjang.

### 5. **Master**

   Namespace `Master` berfungsi untuk mengelompokkan semua entitas master data yang digunakan di seluruh sistem, seperti **Account**, **Unit**, **Patient**, **Doctor**, **Service**, **Supplier**, dan item lainnya. Pengelompokan ini mempermudah dalam mengelola data referensi yang digunakan dalam transaksi lainnya.

Pengelompokan ini membuat struktur aplikasi lebih modular dan mudah dikelola sesuai dengan fungsi dan konteks masing-masing bagian.
