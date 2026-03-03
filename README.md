# Apa itu SIABSEN Kota Solok ?

SIABSEN adalah sistem absensi berbasis QR Code yang dirancang untuk Pemerintah Kota Solok, dikelola oleh Diskominfo Kota Solok. Sistem ini memungkinkan pemantauan kehadiran anggota secara real-time dan rekapitulasi data bagi admin.

## Teknologi Utama (Tech Stack)

Sistem ini dibangun dengan pendekatan modern, ringan, dan responsif:

- **Backend Framework**: [Laravel](https://laravel.com/) (PHP) sebagai mesin utama pengolah data.
- **Database**: [MySQL](https://www.mysql.com/) sebagai media penyimpanan relasional.
- **Frontend Styling**: [Tailwind CSS](https://tailwindcss.com/) (menggunakan CDN) untuk desain UI yang premium dan responsif.
- **Frontend Interactivity**: [Vanilla JavaScript](https://developer.mozilla.org/en-US/docs/Web/JavaScript) untuk logika interaktif tanpa ketergantungan library berat.
- **QR Engine**: [HTML5-QRCode](https://github.com/mebjas/html5-qrcode) untuk pemindaian via kamera perangkat.
- **Date Handling**: [Carbon](https://carbon.nesbot.com/) (PHP) untuk manipulasi waktu dan tanggal.

---

## Struktur Folder & File Penting

### 1. Backend Logic (`app/`)

- [app/Http/Controllers/DashboardController.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php): Mengelola dashboard publik, dashboard admin, statistik kehadiran, dan pembaruan status manual.
- [app/Http/Controllers/ScannerController.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/ScannerController.php): Menangani logika pemindaian QR, validasi token, dan pencatatan log (IN/OUT).
- [app/Models/Anggota.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Models/Anggota.php): Representasi data anggota (nama, foto, token QR, jabatan).
- [app/Models/LogAbsensi.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Models/LogAbsensi.php): Menyimpan setiap riwayat pindaian (IN atau OUT).
- [app/Models/StatusManual.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Models/StatusManual.php): Menyimpan status manual yang diberikan admin (Izin, Tanpa Keterangan).
- [app/Models/User.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Models/User.php): Data akun untuk login admin.

### 2. Tampilan UI (`resources/views/`)

- [resources/views/dashboard/public.blade.php](file:///c:/laragon/www/Siabsen_KotaSolok/resources/views/dashboard/public.blade.php): Halaman utama publik yang menampilkan kehadiran real-time.
- [resources/views/admin/dashboard.blade.php](file:///c:/laragon/www/Siabsen_KotaSolok/resources/views/admin/dashboard.blade.php): Panel kendali admin untuk rekapitulasi, filter status, dan pengaturan sistem.
- [resources/views/admin/scanner.blade.php](file:///c:/laragon/www/Siabsen_KotaSolok/resources/views/admin/scanner.blade.php): Antarmuka kamera pemindai QR.
- [resources/views/auth/login.blade.php](file:///c:/laragon/www/Siabsen_KotaSolok/resources/views/auth/login.blade.php): Halaman akses masuk admin.

### 3. API & Routes (`routes/`)

- [routes/web.php](file:///c:/laragon/www/Siabsen_KotaSolok/routes/web.php): Mendefinisikan semua alur URL baik untuk publik maupun area admin yang dilindungi autentikasi.

---

## Lokasi & Pemetaan File (Map)

Berikut adalah panduan untuk mengetahui file mana yang mengatur fitur tertentu:

### 1. Sistem Absensi & Scanner

- **Alur URL**: [routes/web.php](file:///c:/laragon/www/Siabsen_KotaSolok/routes/web.php) (mencari route `admin/scanner` atau `api/scan-qr`).
- **Logika Scan (Backend)**: [app/Http/Controllers/ScannerController.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/ScannerController.php) pada fungsi [process_scan](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/ScannerController.php#17-90).
- **Tampilan Kamera (Frontend)**: [resources/views/admin/scanner.blade.php](file:///c:/laragon/www/Siabsen_KotaSolok/resources/views/admin/scanner.blade.php).
- **Database Riwayat**: Tabel `log_absensi` yang diatur oleh model [app/Models/LogAbsensi.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Models/LogAbsensi.php).

### 2. Dashboard Publik (Live Stream)

- **Halaman Utama**: [resources/views/dashboard/public.blade.php](file:///c:/laragon/www/Siabsen_KotaSolok/resources/views/dashboard/public.blade.php).
- **Pengambil Data API**: [app/Http/Controllers/DashboardController.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php) pada fungsi [api_live_attendance](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php#24-75).
- **Update Otomatis**: Logika JavaScript di bagian bawah file [public.blade.php](file:///c:/laragon/www/Siabsen_KotaSolok/resources/views/dashboard/public.blade.php) (fungsi `fetchData`).

### 3. Panel Admin (Kelola Data)

- **Halaman Rekap & Dashboard**: [resources/views/admin/dashboard.blade.php](file:///c:/laragon/www/Siabsen_KotaSolok/resources/views/admin/dashboard.blade.php).
- **Logika Statistik & Data**: [app/Http/Controllers/DashboardController.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php) pada fungsi [api_history_attendance](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php#76-150).
- **Kelola Anggota (CRUD)**: [app/Http/Controllers/DashboardController.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php) pada fungsi [api_store_anggota](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php#213-243), [api_delete_anggota](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php#299-313), dll.
- **Model Data Anggota**: [app/Models/Anggota.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Models/Anggota.php).

### 4. Pengaturan Sistem (Cooldown)

- **Logika Simpan/Muat**: [app/Http/Controllers/DashboardController.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php) pada fungsi [api_save_setting](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/DashboardController.php#340-357).
- **Penyimpanan File**: `storage/app/siabsen_settings.json`.

### 5. Keamanan & Login

- **Logika Login/Logout**: [app/Http/Controllers/AuthController.php](file:///c:/laragon/www/Siabsen_KotaSolok/app/Http/Controllers/AuthController.php).
- **Halaman Login**: [resources/views/auth/login.blade.php](file:///c:/laragon/www/Siabsen_KotaSolok/resources/views/auth/login.blade.php).

---

## API Utama (End-to-End)

Sistem menggunakan API internal untuk komunikasi data antara Frontend dan Backend:

- `GET /api/live-attendance`: Mengambil data kehadiran terbaru untuk dashboard publik.
- `GET /api/history-attendance`: Menarik data riwayat dan statistik (Hadir, Izin, Absen) untuk admin.
- `POST /api/scan-qr`: Memvalidasi QR token dan mencatat jam masuk/pulang.
- `POST /api/update-status`: Digunakan admin untuk merubah status kehadiran anggota secara manual.
- `POST /api/settings`: Mengatur konfigurasi sistem seperti "Jeda Antar Scan".

---

## Fitur

1. **Dashboard Publik Real-time**: Visualisasi kehadiran instan dengan sistem filter status yang sinkron.
2. **2-Layer Glassmorphism Design**: Estetika premium menggunakan tumpukan layer pastel, *backdrop blur*, dan mikro-animasi di seluruh elemen UI (Card & Modal).
3. **Smart Scanner Logic**: Otomasi pendeteksian status **MASUK (IN)** dan **PULANG (OUT)** berdasarkan urutan pindaian.
4. **Customizable Scan Cooldown**: Sistem anti-spam yang fleksibel, mendukung jeda pindaian hingga durasi 24 jam.
5. **Sinkronisasi Multi-Board**: Perubahan status manual oleh admin langsung tercermin di dashboard publik tanpa perlu refresh halaman.
6. **QR Identity Management**: Pembuatan token QR otomatis untuk setiap anggota baru yang terdaftar.

---
