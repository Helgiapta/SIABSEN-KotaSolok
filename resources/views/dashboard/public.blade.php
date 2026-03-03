<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Siabsen Kota Solok</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/siabsenlogotrs.png') }}" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <meta name="theme-color" content="#0F4C75"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#0F4C75",
                        "primary-light": "#3282B8",
                        "primary-dark": "#1B262C",
                        "primary-100": "#BBE1FA",
                        "background-light": "#f6f6f8",
                        "background-dark": "#121A1E",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1B262C",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                        body: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 min-h-screen flex flex-col font-body text-slate-800 dark:text-slate-100 antialiased selection:bg-primary-100 selection:text-primary-dark">

<!-- Header Section -->
<header class="bg-white/60 dark:bg-slate-900/60 backdrop-blur-xl border-b border-white/50 dark:border-slate-800 sticky top-0 z-50">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 sm:h-20">
            <div class="flex items-center gap-2 sm:gap-3 text-slate-900 dark:text-white">
                <div class="h-10 w-10 sm:h-12 sm:w-12 bg-blue-500/10 rounded-lg p-1 flex items-center justify-center shrink-0">
                    <img src="{{ asset('assets/images/siabsenlogo.png') }}" alt="Siabsen Logo" class="w-full h-full object-contain filter drop-shadow-sm">
                </div>
                <div class="flex flex-col">
                    <h1 class="text-base sm:text-lg font-bold leading-tight tracking-tight truncate max-w-[150px] sm:max-w-none">SIABSEN Kota Solok</h1>
                    <span class="hidden sm:inline text-[10px] font-medium text-slate-500 dark:text-slate-400">Sistem Informasi Absensi Kota Solok</span>
                </div>
            </div>
            <div class="flex items-center gap-2 sm:gap-4">
                <div class="hidden sm:flex items-center gap-2 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-900/20 rounded-full border border-emerald-200 dark:border-emerald-800/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Online</span>
                </div>
                <a href="{{ route('login') }}" class="flex items-center justify-center px-3 sm:px-4 py-2 gap-1.5 sm:gap-2 rounded-xl bg-primary md:hover:bg-primary-light text-white font-bold text-xs sm:text-sm shadow-lg shadow-primary/30 transition-all md:hover:shadow-primary/50 md:hover:-translate-y-0.5" title="Login Admin">
                    <span class="material-symbols-outlined text-[16px] sm:text-[18px]">admin_panel_settings</span>
                    <span class="hidden sm:inline">Login Admin</span>
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="flex-grow max-w-[1600px] mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 flex flex-col gap-8">
    
    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
        <div class="text-center lg:text-left">
            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-white tracking-tight" id="page-title">Dashboard Publik</h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1" id="page-subtitle">Informasi kehadiran secara real-time</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-slate-100/50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-2xl text-slate-600 dark:text-slate-300 font-black text-[11px] uppercase tracking-[0.15em] shrink-0">
            <span class="material-symbols-outlined text-[18px]">public</span>
            <span>Publik Panel</span>
        </div>
    </div>

    <!-- Dashboard Stats / Clock -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Date Card -->
        <div class="lg:col-span-3 relative group">
            <!-- Stack Layer -->
            <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-3xl translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
            <!-- Main Card -->
            <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-6 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 flex flex-col justify-center items-center h-full transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                <span class="text-primary dark:text-primary-100 text-[10px] font-bold uppercase tracking-[0.2em] mb-4 bg-primary-50 dark:bg-slate-700 px-3 py-1 rounded-full">Kalender</span>
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-primary-100 dark:bg-slate-700 rounded-2xl text-primary dark:text-primary-100">
                        <span class="material-symbols-outlined text-3xl">calendar_month</span>
                    </div>
                    <div>
                        <span class="block text-xl sm:text-2xl font-black text-slate-800 dark:text-white leading-tight" id="current-date">Loading...</span>
                        <span class="block text-slate-500 dark:text-slate-400 text-sm font-medium mt-0.5" id="current-day"></span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Clock Widgets -->
        <div class="lg:col-span-9 grid grid-cols-2 sm:grid-cols-4 gap-6">
            <div class="relative group">
                <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-3xl translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-6 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 flex flex-col items-center justify-center h-full transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                    <span class="text-4xl sm:text-5xl lg:text-6xl font-black text-primary dark:text-primary-100 tabular-nums tracking-tighter drop-shadow-sm" id="clock-hours">--</span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-400 mt-3 uppercase tracking-[0.3em] bg-slate-50 dark:bg-slate-900/50 px-3 py-1 rounded-full">Jam</span>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-3xl translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-6 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 flex flex-col items-center justify-center h-full transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                    <span class="text-4xl sm:text-5xl lg:text-6xl font-black text-primary dark:text-primary-100 tabular-nums tracking-tighter drop-shadow-sm" id="clock-minutes">--</span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-400 mt-3 uppercase tracking-[0.3em] bg-slate-50 dark:bg-slate-900/50 px-3 py-1 rounded-full">Menit</span>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-3xl translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-6 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 flex flex-col items-center justify-center h-full transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                    <span class="text-4xl sm:text-5xl lg:text-6xl font-black text-primary dark:text-primary-100 tabular-nums tracking-tighter drop-shadow-sm" id="clock-seconds">--</span>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-400 mt-3 uppercase tracking-[0.3em] bg-slate-50 dark:bg-slate-900/50 px-3 py-1 rounded-full">Detik</span>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-3xl translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-6 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 flex flex-col items-center justify-center h-full transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                    <span class="text-2xl sm:text-3xl font-black text-primary dark:text-primary-100 uppercase tracking-tight drop-shadow-sm" id="clock-ampm">--</span>
                    <span class="text-[10px] font-bold text-slate-400 mt-3 uppercase tracking-[0.3em] bg-slate-50 dark:bg-slate-900/50 px-3 py-1 rounded-full">Waktu</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Summary Cards (Moved to top) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 mb-8 mt-2">
        <div class="relative group">
            <div class="absolute inset-0 bg-green-100/60 dark:bg-green-900/40 rounded-3xl translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
            <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-8 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-green-900/5 flex items-center justify-between transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Scan Masuk</span>
                    <div class="flex items-baseline gap-2">
                        <p class="text-5xl font-black text-slate-800 dark:text-white tracking-tight" id="stat-datang">0</p>
                        <span class="text-sm font-medium text-slate-400">Pegawai</span>
                    </div>
                </div>
                <div class="p-4 bg-green-50 dark:bg-green-900/50 rounded-2xl text-green-600">
                    <span class="material-symbols-outlined text-4xl">how_to_reg</span>
                </div>
            </div>
        </div>
        
        <div class="relative group">
            <div class="absolute inset-0 bg-blue-100/60 dark:bg-blue-900/40 rounded-3xl translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
            <div class="relative bg-white/90 dark:bg-slate-800/90 backdrop-blur-md p-8 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-blue-900/5 flex items-center justify-between transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                <div class="flex flex-col">
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Scan Pulang</span>
                    <div class="flex items-baseline gap-2">
                        <p class="text-5xl font-black text-slate-800 dark:text-white tracking-tight" id="stat-pulang">0</p>
                        <span class="text-sm font-medium text-slate-400">Pegawai</span>
                    </div>
                </div>
                <div class="p-4 bg-blue-50 dark:bg-blue-900/50 rounded-2xl text-blue-600">
                    <span class="material-symbols-outlined text-4xl">logout</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Attendance Table Section -->
    <div class="relative group mt-4 h-full mb-8">
        <div class="absolute inset-0 bg-slate-200/60 dark:bg-slate-700/50 rounded-[2rem] translate-y-2.5 translate-x-2.5 transition-transform md:group-hover:translate-y-3.5 md:group-hover:translate-x-3.5"></div>
        <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-[2rem] border border-white dark:border-slate-700 shadow-xl shadow-slate-900/5 overflow-hidden flex flex-col transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
            <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-700/50 flex flex-col gap-4">
                <!-- Baris 1: Judul + Search -->
                <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <div>
                        <h3 class="font-black text-xl text-slate-800 dark:text-white flex items-center gap-3">
                            <span class="p-2 bg-slate-100 dark:bg-slate-900/50 rounded-xl text-slate-600 material-symbols-outlined">groups</span>
                            Presensi Real-time
                        </h3>
                        <p class="text-sm text-slate-400 mt-1 sm:ml-12">Data diperbarui otomatis setiap 5 detik</p>
                    </div>
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <div class="relative w-full sm:w-64">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px]">search</span>
                            <input id="searchInput" class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all" placeholder="Cari nama anggota..." type="text"/>
                        </div>
                        <button onclick="fetchData()" class="p-2.5 text-slate-400 md:hover:text-primary transition-colors bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm md:hover:shadow-md">
                            <span class="material-symbols-outlined text-[20px]" id="refresh-icon">refresh</span>
                        </button>
                    </div>
                </div>
                <!-- Baris 2: Filter chips -->
                <div class="flex flex-wrap gap-2 items-center">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest shrink-0">Status Scan:</span>
                    <button data-scan="" onclick="setScanFilter(this)" class="filter-scan active-filter px-3 py-1 rounded-full text-xs font-bold border border-primary bg-primary text-white transition-all">Semua</button>
                    <button data-scan="Datang" onclick="setScanFilter(this)" class="filter-scan px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white text-slate-600 hover:border-primary hover:text-primary transition-all">IN (Datang)</button>
                    <button data-scan="Pulang" onclick="setScanFilter(this)" class="filter-scan px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white text-slate-600 hover:border-primary hover:text-primary transition-all">OUT (Pulang)</button>
                    <span class="text-slate-200 mx-1">|</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest shrink-0">Status Kehadiran:</span>
                    <button data-status="" onclick="setStatusFilter(this)" class="filter-status active-filter px-3 py-1 rounded-full text-xs font-bold border border-primary bg-primary text-white transition-all">Semua</button>
                    <button data-status="Hadir Penuh" onclick="setStatusFilter(this)" class="filter-status px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white text-slate-600 hover:border-green-500 hover:text-green-600 transition-all">Hadir Penuh</button>
                    <button data-status="Hadir Setengah" onclick="setStatusFilter(this)" class="filter-status px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white text-slate-600 hover:border-yellow-500 hover:text-yellow-600 transition-all">Hadir Setengah</button>
                    <button data-status="Izin" onclick="setStatusFilter(this)" class="filter-status px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white text-slate-600 hover:border-blue-500 hover:text-blue-600 transition-all">Izin</button>
                    <button data-status="Tidak Hadir" onclick="setStatusFilter(this)" class="filter-status px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white text-slate-600 hover:border-red-500 hover:text-red-600 transition-all">Tidak Hadir</button>
                </div>
            </div>
            
            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-[10px] sm:text-xs font-bold uppercase tracking-widest sticky top-0 z-10">
                    <tr>
                        <th class="px-4 sm:px-6 py-4 rounded-tl-lg min-w-[200px]">Anggota</th>
                        <th class="px-4 py-4 text-center">Status Scan</th>
                        <th class="px-4 py-4 text-center">Waktu</th>
                        <th class="px-4 py-4 text-center rounded-tr-lg">Status Hari Ini</th>
                    </tr>
                </thead>
                <tbody id="attendance-table-body" class="divide-y divide-slate-100 dark:divide-slate-700">
                    <tr>
                        <td colspan="4" class="px-6 py-10 justify-center text-center">
                            Memuat data real-time...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        </div>
    </div>
</main>

<!-- Footer -->
<footer class="bg-white/50 backdrop-blur-lg dark:bg-slate-900/50 border-t border-white/50 dark:border-slate-800 mt-auto">
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-3">
            <p class="text-sm text-slate-500 dark:text-slate-400 text-center md:text-left">
                © {{ date('Y') }}
                <a href="https://solokkota.go.id/" target="_blank" rel="noopener" class="hover:text-primary transition-colors font-medium">Pemerintah Kota Solok</a>
                · Dikelola oleh
                <a href="https://kominfo.solokkota.go.id/" target="_blank" rel="noopener" class="hover:text-primary transition-colors font-medium">Diskominfo Kota Solok</a>
            </p>
            <div class="flex gap-6 text-sm text-slate-500 dark:text-slate-400">
                <a class="hover:text-primary transition-colors font-medium flex items-center gap-1" href="{{ route('public.dashboard') }}">
                    <span class="material-symbols-outlined text-[16px]">fingerprint</span>
                    SIABSEN Kota Solok
                </a>
            </div>
        </div>
    </div>
</footer>

<script>
    function updateClock() {
        const now = new Date();
        const dateOptions = { month: 'short', day: 'numeric', year: 'numeric' };
        const dayOptions = { weekday: 'long' };
        
        let hours = now.getHours();
        
        let waktuSapaan = 'MALAM';
        if (hours >= 4 && hours < 11) {
            waktuSapaan = 'PAGI';
        } else if (hours >= 11 && hours < 15) {
            waktuSapaan = 'SIANG';
        } else if (hours >= 15 && hours < 18) {
            waktuSapaan = 'SORE';
        }

        document.getElementById('current-date').textContent = now.toLocaleDateString('id-ID', dateOptions).replace(/ /, ', ');
        document.getElementById('current-day').textContent = now.toLocaleDateString('id-ID', dayOptions);
        
        document.getElementById('clock-hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('clock-minutes').textContent = now.getMinutes().toString().padStart(2, '0');
        document.getElementById('clock-seconds').textContent = now.getSeconds().toString().padStart(2, '0');
        document.getElementById('clock-ampm').textContent = waktuSapaan;
    }
    
    setInterval(updateClock, 1000);
    updateClock();

    let attendanceData = [];

    async function fetchData() {
        const refreshIcon = document.getElementById('refresh-icon');
        refreshIcon.classList.add('animate-spin');

        try {
            const response = await fetch('/api/live-attendance');
            const data = await response.json();
            
            if (data.status === 'success') {
                attendanceData = data.data;
                renderTable(attendanceData);
            }
        } catch (error) {
            console.error("Failed to fetch data", error);
        } finally {
            setTimeout(() => { refreshIcon.classList.remove('animate-spin'); }, 500);
        }
    }

    function renderTable(data) {
        const tbody = document.getElementById('attendance-table-body');
        const searchInput = document.getElementById('searchInput').value.toLowerCase();
        
        tbody.innerHTML = '';
        
        let statDatang = 0;
        let statPulang = 0;

        let filteredData = data.filter(item => item.nama.toLowerCase().includes(searchInput));
        if (activeScanFilter)   filteredData = filteredData.filter(i => i.tipe_absen === activeScanFilter);
        if (activeStatusFilter) filteredData = filteredData.filter(i => i.status_hari_ini === activeStatusFilter);

        if (filteredData.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">Tidak ada data yang cocok dengan filter yang dipilih</td></tr>`;
            document.getElementById('stat-datang').innerText = '0';
            document.getElementById('stat-pulang').innerText = '0';
            return;
        }

        filteredData.forEach(item => {
            const initials = item.nama.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
            
            let typeBadge = '';
            let statusBadge = '';

            if (item.tipe_absen === 'Datang') {
                statDatang++;
                typeBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm flex items-center w-fit gap-1"><span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> IN (Datang)</span>`;
            } else {
                statPulang++;
                typeBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-50 text-slate-700 border border-slate-200 shadow-sm flex items-center w-fit gap-1"><span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> OUT (Pulang)</span>`;
            }

            if (item.status_hari_ini === 'Hadir Penuh') {
                statusBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-200 shadow-sm flex items-center w-fit gap-1"><span class="material-symbols-outlined text-[12px]">check_circle</span> Hadir Penuh</span>`;
            } else if (item.status_hari_ini === 'Hadir Setengah') {
                statusBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-200 shadow-sm flex items-center w-fit gap-1"><span class="material-symbols-outlined text-[12px]">schedule</span> Hadir Setengah</span>`;
            } else if (item.status_hari_ini === 'Izin') {
                statusBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200 shadow-sm flex items-center w-fit gap-1"><span class="material-symbols-outlined text-[12px]">assignment_late</span> Izin</span>`;
            } else {
                statusBadge = `<span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-200 shadow-sm flex items-center w-fit gap-1"><span class="material-symbols-outlined text-[12px]">cancel</span> Tidak Hadir</span>`;
            }

            const row = `
                <tr class="group md:hover:bg-slate-50 dark:md:hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 font-bold text-sm">${initials}</div>
                            <div>
                                <p class="font-medium text-slate-900 dark:text-slate-100">${item.nama}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center">
                            ${typeBadge}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2 text-slate-600 dark:text-slate-300">
                            <span class="material-symbols-outlined text-[18px] text-slate-400">schedule</span>
                            <span class="font-mono text-sm">${item.waktu}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center">
                            ${statusBadge}
                        </div>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML('beforeend', row);
        });

        document.getElementById('stat-datang').innerText = statDatang;
        document.getElementById('stat-pulang').innerText = statPulang;
    }

    let activeScanFilter = '';
    let activeStatusFilter = '';

    function setScanFilter(btn) {
        activeScanFilter = btn.dataset.scan;
        document.querySelectorAll('.filter-scan').forEach(b => {
            b.classList.remove('active-filter', 'bg-primary', 'text-white', 'border-primary');
            b.classList.add('bg-white', 'text-slate-600', 'border-slate-200');
        });
        btn.classList.add('active-filter', 'bg-primary', 'text-white', 'border-primary');
        btn.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');
        renderTable(attendanceData);
    }

    function setStatusFilter(btn) {
        activeStatusFilter = btn.dataset.status;
        document.querySelectorAll('.filter-status').forEach(b => {
            b.classList.remove('active-filter', 'bg-primary', 'text-white', 'border-primary');
            b.classList.add('bg-white', 'text-slate-600', 'border-slate-200');
        });
        btn.classList.add('active-filter', 'bg-primary', 'text-white', 'border-primary');
        btn.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');
        renderTable(attendanceData);
    }

    document.getElementById('searchInput').addEventListener('input', () => {
        renderTable(attendanceData);
    });

    setInterval(fetchData, 5000);
    
    document.addEventListener("DOMContentLoaded", fetchData);

</script>
</body>
</html>
