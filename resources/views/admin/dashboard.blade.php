<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard Admin - Siabsen Kota Solok</title>
    <meta name="theme-color" content="#0F4C75"/>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/siabsenlogotrs.png') }}" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                        "display": ["Inter", "sans-serif"],
                        "sans": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-display min-h-screen flex flex-col">
    <!-- Top Navigation -->
    <header class="bg-white/60 dark:bg-slate-900/60 backdrop-blur-xl border-b border-white/50 dark:border-slate-800 sticky top-0 z-50">
        <div class="w-full max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16 sm:h-20">
            <div class="flex items-center gap-3">
                <!-- Mobile Menu Toggle -->
                <button onclick="toggleMobileMenu()" class="lg:hidden p-2 text-slate-500 hover:bg-slate-100 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="flex items-center gap-3">
                    <div class="size-8 sm:size-10 bg-blue-500/10 rounded-lg p-1 flex items-center justify-center shrink-0">
                        <img src="{{ asset('assets/images/siabsenlogo.png') }}" alt="Logo" class="w-full h-full object-contain filter drop-shadow-sm">
                    </div>
                    <h1 class="text-lg sm:text-xl font-bold tracking-tight text-slate-900 dark:text-white truncate">Admin SIABSEN</h1>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-6">
                <!-- Desktop Navigation Buttons -->
                <div class="hidden lg:flex gap-3">
                    <a href="{{ route('public.dashboard') }}" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 px-4 py-2.5 rounded-xl font-bold text-sm transition-colors border border-slate-200 dark:border-slate-700">
                        <span class="material-symbols-outlined text-xl">public</span>
                        <span>Dashboard Publik</span>
                    </a>
                    <a href="{{ route('admin.scanner') }}" class="flex items-center gap-2 bg-primary hover:bg-primary-light text-white px-4 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary-light/30 transition-all hover:shadow-primary-light/50 hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-xl">qr_code_scanner</span>
                        <span>BUKA SCANNER</span>
                    </a>
                </div>

                <!-- User Profile & Logout -->
                <div class="flex items-center gap-3 sm:pl-6 sm:border-l border-slate-200 dark:border-slate-700">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white truncate max-w-[120px]">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Kota Solok</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center justify-center size-9 sm:size-10 rounded-full bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 transition-colors" title="Logout">
                            <span class="material-symbols-outlined text-[18px] sm:text-[20px]">logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        </div>
    </header>

    <!-- Mobile Drawer Menu (Moved outside header for true z-index overlay) -->
    <div id="mobile-menu" class="lg:hidden fixed inset-0 z-[100] hidden pointer-events-none transition-all duration-300">
        <div id="mobile-menu-backdrop" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300" onclick="toggleMobileMenu()"></div>
        <div id="mobile-menu-drawer" class="absolute left-0 top-0 bottom-0 w-72 bg-white dark:bg-surface-dark shadow-2xl flex flex-col p-6 pointer-events-auto transform -translate-x-full transition-transform duration-300 ease-in-out z-[101]">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('assets/images/siabsenlogo.png') }}" alt="Logo" class="size-8">
                    <span class="font-bold text-xl">SIABSEN</span>
                </div>
                <button onclick="toggleMobileMenu()" class="text-slate-400 hover:text-slate-900">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <nav class="flex flex-col gap-4">
                <a href="{{ route('public.dashboard') }}" class="flex items-center gap-3 p-4 bg-slate-50 dark:bg-slate-800 rounded-xl font-bold text-slate-700 dark:text-slate-200">
                    <span class="material-symbols-outlined">public</span> Dashboard Publik
                </a>
                <a href="{{ route('admin.scanner') }}" class="flex items-center gap-3 p-4 bg-primary text-white rounded-xl font-bold shadow-lg shadow-primary/20">
                    <span class="material-symbols-outlined">qr_code_scanner</span> BUKA SCANNER
                </a>

                <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4">Navigasi Tab</p>
                    <button onclick="switchTab('rekap'); toggleMobileMenu()" class="w-full flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl text-left font-semibold">
                        <span class="material-symbols-outlined">calendar_month</span> Rekap Absensi
                    </button>
                    <button onclick="switchTab('anggota'); toggleMobileMenu()" class="w-full flex items-center gap-3 p-4 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-xl text-left font-semibold">
                        <span class="material-symbols-outlined">manage_accounts</span> Data Anggota
                    </button>
                </div>
            </nav>

            <div class="mt-auto pt-6 text-center">
                <p class="text-xs text-slate-400">© {{ date('Y') }} Kota Solok</p>
            </div>
        </div>
    </div>

    <main class="flex-1 w-full max-w-[1600px] mx-auto p-4 sm:p-6 lg:p-8 flex flex-col gap-8">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-2">
            <div class="text-center lg:text-left">
                <h2 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-white tracking-tight" id="page-title">Dashboard Admin</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1" id="page-subtitle">Pantau jadwal dan riwayat presensi harian anggota</p>
            </div>
            
            <div class="relative self-center lg:self-auto pr-1 pb-1">
                <!-- Inner backing limits to container so it doesnt bleed translate bounds -->
                <div class="absolute inset-0 bg-primary-100 dark:bg-slate-700 rounded-xl translate-y-1 translate-x-1"></div>
                <!-- Interactive Button Group container -->
                <div class="relative flex bg-white/95 dark:bg-slate-800/95 backdrop-blur-md p-1.5 rounded-xl border border-slate-200 dark:border-slate-600 w-max max-w-full">
                    <button onclick="switchTab('rekap')" id="btn-tab-rekap" class="whitespace-nowrap px-4 py-2 bg-primary-50 dark:bg-slate-700 rounded-lg text-sm font-bold text-primary dark:text-white shadow-sm transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">calendar_month</span> Rekap
                    </button>
                    <button onclick="switchTab('anggota')" id="btn-tab-anggota" class="whitespace-nowrap px-4 py-2 text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg text-sm font-medium transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">manage_accounts</span> Data Anggota
                    </button>
                </div>
            </div>
        </div>

        <!-- ==============================
             TAB: REKAPITULASI
             ============================== -->
        <div id="tab-rekap" class="grid grid-cols-1 xl:grid-cols-12 gap-8 h-full">
            
            <!-- Left Column: Calendar (Large) -->
            <div class="xl:col-span-4 flex flex-col gap-6">
                <!-- Stats Summary -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-3xl translate-y-1.5 translate-x-1.5 transition-transform md:hover:translate-y-2.5 md:hover:translate-x-2.5"></div>
                        <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md p-5 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 flex lg:flex-col items-center lg:items-start gap-4 lg:gap-0 transition-transform md:hover:-translate-y-1 md:hover:-translate-x-1">
                            <div class="p-2.5 bg-primary-100 dark:bg-slate-700 text-primary dark:text-primary-100 rounded-2xl mb-2">
                                <span class="material-symbols-outlined text-2xl">how_to_reg</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Hadir</span>
                                <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tight" id="stat-hadir">0 <span class="text-sm font-normal text-slate-400">/ 0</span></p>
                            </div>
                        </div>
                    </div>
                    <div class="relative group">
                        <div class="absolute inset-0 bg-red-100/60 dark:bg-red-900/30 rounded-3xl translate-y-1.5 translate-x-1.5 transition-transform md:group-hover:translate-y-2.5 md:group-hover:translate-x-2.5"></div>
                        <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md p-5 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-red-900/5 flex lg:flex-col items-center lg:items-start gap-4 lg:gap-0 transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                            <div class="p-2.5 bg-red-50 dark:bg-red-900/50 text-red-500 rounded-2xl mb-2">
                                <span class="material-symbols-outlined text-2xl">person_off</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Tanpa Ket.</span>
                                <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tight" id="stat-absen">0 <span class="text-sm font-normal text-slate-400">org</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Card -->
                <div class="relative group flex-1 min-h-[400px]">
                    <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-[2rem] translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                    <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-[2rem] border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 overflow-hidden flex flex-col h-full transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                        <div class="p-6 border-b border-primary-100/30 dark:border-slate-800/50 flex items-center justify-between">
                            <h3 class="font-black text-lg text-primary-dark dark:text-white tracking-tight flex items-center gap-2" id="calendar-header">
                                <span class="material-symbols-outlined text-primary">calendar_month</span>
                                Bulan Tahun
                            </h3>
                            <div class="flex gap-2">
                                <button id="btn-prev-month" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 hover:text-primary rounded-xl transition-colors">
                                    <span class="material-symbols-outlined">chevron_left</span>
                                </button>
                                <button id="btn-next-month" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 hover:text-primary rounded-xl transition-colors">
                                    <span class="material-symbols-outlined">chevron_right</span>
                                </button>
                            </div>
                        </div>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="grid grid-cols-7 mb-3">
                                <div class="text-center text-[10px] font-bold text-red-500 uppercase py-2">Min</div>
                                <div class="text-center text-[10px] font-bold text-slate-400 uppercase py-2">Sen</div>
                                <div class="text-center text-[10px] font-bold text-slate-400 uppercase py-2">Sel</div>
                                <div class="text-center text-[10px] font-bold text-slate-400 uppercase py-2">Rab</div>
                                <div class="text-center text-[10px] font-bold text-slate-400 uppercase py-2">Kam</div>
                                <div class="text-center text-[10px] font-bold text-slate-400 uppercase py-2">Jum</div>
                                <div class="text-center text-[10px] font-bold text-slate-400 uppercase py-2">Sab</div>
                            </div>
                            <div class="grid grid-cols-7 gap-y-2 gap-x-2 flex-1" id="calendar-grid">
                                <!-- JS will populate calendar days here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Detail List (Takes remainder) -->
            <div class="xl:col-span-8 flex flex-col gap-6">
                <div class="relative group h-full flex flex-col">
                    <div class="absolute inset-0 bg-slate-200/60 dark:bg-slate-700/50 rounded-[2rem] translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                    <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-[2rem] border border-white dark:border-slate-700 shadow-xl shadow-slate-900/5 overflow-hidden flex flex-col h-full transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                        
                        <!-- Header of List -->
                        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800/50 flex flex-col sm:flex-row justify-between sm:items-center gap-6">
                            <div>
                                <h3 class="font-black text-xl text-primary-dark dark:text-white flex items-center gap-3">
                                    <span class="p-2 bg-slate-100 dark:bg-slate-900/50 rounded-xl text-slate-600 material-symbols-outlined">history</span>
                                    Riwayat Kehadiran
                                </h3>
                                <p class="text-sm text-slate-500 mt-1 sm:ml-12">Tanggal Terpilih: <span class="font-bold text-primary dark:text-primary-100" id="selected-date-text">-</span></p>
                            </div>
                            <div class="relative w-full sm:w-64">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px]">search</span>
                                <input id="search-input" class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all" placeholder="Cari nama anggota..." type="text"/>
                            </div>
                        </div>

                        <!-- Table Container -->
                        <div class="@container w-full overflow-x-auto flex-1">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-[10px] sm:text-xs font-bold uppercase tracking-widest sticky top-0 z-10">
                                <tr>
                                    <th class="px-4 sm:px-6 py-4 rounded-tl-lg min-w-[200px]">Anggota</th>
                                    <th class="px-4 py-4 text-center">Status</th>
                                    <th class="px-4 py-4 text-center">Masuk</th>
                                    <th class="px-4 py-4 text-center">Pulang</th>
                                    <th class="px-4 py-4 text-right rounded-tr-lg">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm" id="history-table-body">
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                        Memuat data...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div> <!-- End of Tab Rekap -->

        <!-- ==============================
             TAB: KELOLA ANGGOTA
             ============================== -->
        <div id="tab-anggota" class="hidden flex-col gap-6">
            <div class="relative group min-h-[500px] flex flex-col">
                <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-[2rem] translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-[2rem] border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 overflow-hidden flex flex-col h-full transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                    <div class="px-5 sm:px-8 py-5 sm:py-6 border-b border-primary-100/30 dark:border-slate-800/50 flex flex-col sm:flex-row justify-between items-center gap-4 w-full min-w-0">
                        <h3 class="font-black text-xl text-primary-dark dark:text-white flex items-center justify-center w-full sm:w-auto gap-3 text-center sm:text-left">
                            <span class="p-2 bg-primary-100 dark:bg-slate-700 rounded-xl text-primary material-symbols-outlined hidden sm:inline-block">group</span>
                            Daftar Anggota Aktif
                        </h3>
                        <button onclick="openModalTambah()" class="bg-primary hover:bg-primary-light text-white w-full sm:w-auto px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/30 transition-all hover:-translate-y-0.5 flex justify-center items-center gap-2 whitespace-nowrap">
                            <span class="material-symbols-outlined text-[18px]">person_add</span> Tambah Anggota
                        </button>
                    </div>
                    <div class="overflow-x-auto w-full flex-1">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-primary-50/50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-[10px] sm:text-xs font-bold uppercase tracking-widest">
                            <tr>
                                <th class="px-3 sm:px-6 py-4 w-12 sm:w-16 text-center">No</th>
                                <th class="px-3 sm:px-6 py-4 min-w-[200px]">Anggota</th>
                                <th class="px-3 sm:px-6 py-4 w-32 sm:w-64 text-center">QR Code</th>
                                <th class="px-3 sm:px-6 py-4 w-20 sm:w-32 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="anggota-table-body" class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                            <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Memuat anggota...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- End of Tab Anggota -->

    </main>

    <!-- ==============================
         MODALS
         ============================== -->
    <!-- Modal Tambah Anggota -->
    <div id="modal-tambah" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px]" onclick="closeModalTambah()"></div>
        <div class="bg-white dark:bg-surface-dark w-full max-w-md rounded-2xl shadow-2xl relative z-10 p-6 transform transition-all duration-200 scale-95 opacity-0" id="modal-tambah-content">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Tambah Anggota Baru</h3>
                <button onclick="closeModalTambah()" class="text-slate-400 hover:text-red-500 p-1 rounded-lg hover:bg-red-50 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Sistem terotomatisasi membuat token QR Identity bagi anggota baru yang terdaftar.</p>
            
            <form id="form-tambah-anggota" onsubmit="submitFormTambah(event)">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap Anggota</label>
                    <input type="text" id="input-nama-anggota" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary/50 focus:bg-white focus:border-primary text-slate-900 dark:text-white font-medium placeholder-slate-400 transition-all" placeholder="Nama Lengkap Anggota">
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Foto Profil (Opsional)</label>
                    <input type="file" id="input-foto-anggota" accept="image/jpeg, image/png, image/webp" class="w-full px-3 py-2 text-sm bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                    <p class="text-xs text-slate-500 mt-1">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                </div>
                <div class="flex flex-col-reverse relative sm:flex-row gap-3 sm:justify-end">
                    <button type="button" onclick="closeModalTambah()" class="px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 transition-colors">Batal</button>
                    <button type="submit" id="btn-submit-anggota" class="px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:bg-blue-700 shadow-md shadow-blue-500/30 transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">app_registration</span> Daftarkan & Buat QR
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Preview & Update Foto -->
    <div id="modal-foto" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px]" onclick="closeModalFoto()"></div>
        <div class="bg-white dark:bg-surface-dark w-full max-w-sm rounded-2xl shadow-2xl relative z-10 p-6 transform transition-all duration-200 scale-95 opacity-0 flex flex-col items-center" id="modal-foto-content">
            <button onclick="closeModalFoto()" class="absolute top-4 right-4 text-slate-400 hover:text-red-500 p-1 rounded-lg hover:bg-red-50 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
            
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 w-full text-center" id="preview-foto-nama">Foto Profil</h3>
            
            <div class="size-40 rounded-full bg-slate-100 relative mb-6 overflow-hidden border-4 border-white shadow-lg">
                <img src="" id="preview-foto-img" alt="Foto Profil" class="w-full h-full object-cover">
            </div>

            <form id="form-update-foto" class="w-full flex flex-col gap-3" onsubmit="submitFormUpdateFoto(event)">
                <input type="hidden" id="update-foto-id">
                <div class="relative w-full">
                    <input type="file" id="update-foto-file" required accept="image/jpeg, image/png, image/webp" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="document.getElementById('file-name-display').textContent = this.files[0] ? this.files[0].name : 'Pilih Foto Baru...'">
                    <div class="w-full px-4 py-3 bg-slate-50 border border-dashed border-slate-300 text-center rounded-xl flex items-center justify-center gap-2 text-slate-600 font-medium text-sm">
                        <span class="material-symbols-outlined text-lg">upload_file</span>
                        <span id="file-name-display">Pilih Foto Baru...</span>
                    </div>
                </div>
                <div class="flex flex-col gap-2 w-full mt-2">
                    <button type="submit" id="btn-submit-foto" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-xl font-bold transition-colors flex items-center justify-center gap-2 text-sm shadow-md">
                        <span class="material-symbols-outlined text-[18px]">save</span> Simpan Foto Baru
                    </button>
                    <button type="button" id="btn-hapus-foto" onclick="deleteFotoAnggota()" class="w-full py-2.5 bg-red-50 hover:bg-red-100 text-red-600 rounded-xl font-bold transition-colors flex items-center justify-center gap-2 text-sm border border-red-200">
                        <span class="material-symbols-outlined text-[18px]">delete</span> Hapus Foto
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Zoom QR Code -->
    <div id="modal-qr" class="fixed inset-0 z-[100] hidden flex-col items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/80 backdrop-blur-sm" onclick="closeModalQR()"></div>
        <div class="bg-white dark:bg-surface-dark w-full max-w-sm rounded-3xl shadow-2xl relative z-10 p-8 transform transition-all duration-200 scale-95 opacity-0 flex flex-col items-center" id="modal-qr-content">
            <button onclick="closeModalQR()" class="absolute top-4 right-4 text-slate-400 hover:text-red-500 p-1 rounded-lg hover:bg-red-50 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>

            <div class="text-center mb-6 w-full">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white" id="zoom-qr-nama">Nama Anggota</h3>
                <p class="text-xs text-slate-500 font-mono mt-1" id="zoom-qr-token">Token ID</p>
            </div>

            <div class="p-4 bg-white border border-slate-200 shadow-sm rounded-2xl mb-8">
                <img src="" id="zoom-qr-img" alt="QR Code Full" class="size-64 object-contain">
            </div>

            <a href="#" download="QR_Code.png" id="btn-download-qr" class="w-full py-3 bg-primary hover:bg-blue-700 text-white rounded-xl font-bold transition-colors flex items-center justify-center gap-2 shadow-lg shadow-blue-500/30">
                <span class="material-symbols-outlined text-lg">download</span>
                Unduh QR Code
            </a>
        </div>
    </div>

    <!-- Modal Konfirmasi Universal -->
    <div id="modal-confirm" class="fixed inset-0 z-[110] hidden flex-col items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[2px]" onclick="closeConfirmModal()"></div>
        <div class="bg-white dark:bg-surface-dark w-full max-w-sm rounded-2xl shadow-2xl relative z-10 p-6 transform transition-all duration-200 scale-95 opacity-0" id="modal-confirm-content">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2" id="confirm-title">Konfirmasi</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6 leading-relaxed" id="confirm-message">Apakah Anda yakin?</p>
            
            <div class="flex flex-col sm:flex-row gap-3 sm:justify-end w-full">
                <button type="button" onclick="closeConfirmModal()" class="w-full sm:w-auto px-5 py-2.5 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 transition-colors">Batal</button>
                <button type="button" id="btn-confirm-action" onclick="executeConfirm()" class="w-full sm:w-auto px-5 py-2.5 rounded-lg text-sm font-bold text-white shadow-md transition-all focus:ring-2 focus:outline-none">
                    Ya, Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <script>
        // Callback Penyimpanan Konfirmasi
        let confirmCallback = null;

        function openConfirmModal(title, message, btnText, btnColorClass, callback) {
            const modal = document.getElementById('modal-confirm');
            const content = document.getElementById('modal-confirm-content');
            
            document.getElementById('confirm-title').textContent = title;
            document.getElementById('confirm-message').innerHTML = message; // Berjalan pake .innerHTML buat render <br> tag jika ada
            
            const btn = document.getElementById('btn-confirm-action');
            btn.textContent = btnText;
            btn.className = `w-full sm:w-auto px-5 py-2.5 rounded-lg text-sm font-bold text-white shadow-md transition-all focus:ring-2 focus:outline-none ${btnColorClass}`;
            
            confirmCallback = callback;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeConfirmModal() {
            const modal = document.getElementById('modal-confirm');
            const content = document.getElementById('modal-confirm-content');
            
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                confirmCallback = null;
            }, 200);
        }

        function executeConfirm() {
            if (confirmCallback) {
                confirmCallback();
            }
            closeConfirmModal();
        }

        // API Base URL
        const API_HISTORY_URL = "{{ url('api/history-attendance') }}";
        
        let currentDate = new Date();
        let selectedDate = new Date(); // Default hari ini
        
        // Element caching
        const elCalendarGrid = document.getElementById('calendar-grid');
        const elCalendarHeader = document.getElementById('calendar-header');
        const elSelectedDateText = document.getElementById('selected-date-text');
        const elTableBody = document.getElementById('history-table-body');
        const elSearchInput = document.getElementById('search-input');
        
        const elStatHadir = document.getElementById('stat-hadir');
        const elStatAbsen = document.getElementById('stat-absen');

        let currentHistoryData = [];

        // Inisialisasi awal
        document.addEventListener('DOMContentLoaded', () => {
            renderCalendar();
            fetchHistoryData(selectedDate);

            // Listeners navigasi bulan
            document.getElementById('btn-prev-month').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });
            document.getElementById('btn-next-month').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            // Listener pencarian
            elSearchInput.addEventListener('input', (e) => {
                const term = e.target.value.toLowerCase();
                renderTable(currentHistoryData, term);
            });
        });

        // ==========================================
        // 🗓️ RENDER KALENDER (Vanilla JS)
        // ==========================================
        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            
            // Format Header "Bulan Tahun"
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            elCalendarHeader.textContent = `${monthNames[month]} ${year}`;

            elCalendarGrid.innerHTML = '';

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            // Isi slot kosong sebelum tanggal 1
            for (let i = 0; i < firstDay; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'aspect-square flex items-center justify-center';
                elCalendarGrid.appendChild(emptyDiv);
            }

            // Isi tanggal dari 1 s/d hari terakhir bulan ini
            for (let day = 1; day <= daysInMonth; day++) {
                const targetDateObj = new Date(year, month, day);
                const btn = document.createElement('button');
                
                // Styling dasar
                btn.className = `aspect-square flex flex-col items-center justify-center rounded-lg relative group transition-colors `;
                
                // Cek apakah ini hari yang sedang dipilih (selected)
                if (targetDateObj.toDateString() === selectedDate.toDateString()) {
                    btn.className += `bg-primary text-white shadow-lg shadow-primary/30`;
                    btn.innerHTML = `<span class="text-sm font-bold">${day}</span>`;
                } else {
                    btn.className += `md:hover:bg-slate-50 dark:md:hover:bg-slate-800 text-slate-700 dark:text-slate-300`;
                    btn.innerHTML = `<span class="text-sm font-medium">${day}</span>`;
                }

                // Cek apakah hari ini (aktual)
                const today = new Date();
                if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear() && targetDateObj.toDateString() !== selectedDate.toDateString()) {
                    btn.classList.add('border-2', 'border-primary', 'font-bold');
                }

                btn.onclick = () => {
                    selectedDate = new Date(year, month, day);
                    renderCalendar(); // Re-render kalender untuk mindahin highlight
                    fetchHistoryData(selectedDate);
                };

                elCalendarGrid.appendChild(btn);
            }
        }

        // ==========================================
        // 📡 FETCH API DAN PERHITUNGAN DATATABLE
        // ==========================================
        function fetchHistoryData(dateObj) {
            // Format API butuh YYYY-MM-DD
            const yyyy = dateObj.getFullYear();
            const mm = String(dateObj.getMonth() + 1).padStart(2, '0');
            const dd = String(dateObj.getDate()).padStart(2, '0');
            const formattedDate = `${yyyy}-${mm}-${dd}`;

            // Update Teks Tanggal Terpilih (ID)
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            elSelectedDateText.textContent = dateObj.toLocaleDateString('id-ID', options);

            elTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        Memuat data absen tanggal ${formattedDate}...
                    </td>
                </tr>
            `;

            fetch(`${API_HISTORY_URL}?date=${formattedDate}`)
                .then(res => res.json())
                .then(data => {
                    currentHistoryData = data.data || [];
                    
                    // Update Stat Atas
                    const totalAnggota = data.total_anggota || 0;
                    const hadir = (data.statistik.hadir_penuh || 0) + (data.statistik.hadir_setengah || 0);
                    // Jumlahkan Alfa dari semua yang bukan Hadir
                    const absen = (data.statistik.absen || 0) + (data.statistik.izin || 0) + (data.statistik.sakit || 0) + (data.statistik.cuti || 0);
                    
                    elStatHadir.innerHTML = `${hadir} <span class="text-xs font-normal text-slate-400">/ ${totalAnggota}</span>`;
                    elStatAbsen.innerHTML = `${absen} <span class="text-xs font-normal text-slate-400">orang</span>`;

                    renderTable(currentHistoryData, '');
                })
                .catch(err => {
                    console.error('Error fetching data:', err);
                    elTableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Gagal memuat data.</td></tr>`;
                });
        }

        function renderTable(dataArray, searchTerm = '') {
            elTableBody.innerHTML = '';

            // Filter
            if (searchTerm) {
                dataArray = dataArray.filter(item => 
                    item.nama.toLowerCase().includes(searchTerm)
                );
            }

            if (dataArray.length === 0) {
                 elTableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">Tidak ada data kehadiran yang ditemukan.</td></tr>`;
                 return;
            }

            // Loop Data
            dataArray.forEach(item => {
                const safeName = item.nama ? String(item.nama).replace(/"/g, '&quot;').replace(/'/g, '&#39;') : "Tanpa Nama";
                
                // Tentukan Badge Status
                let statusBadge = '';
                if (item.status_hari_ini === 'Hadir Penuh') {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 gap-1.5"><span class="material-symbols-outlined text-[14px]">check_circle</span> Hadir Penuh</span>`;
                } else if (item.status_hari_ini === 'Hadir Setengah') {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 gap-1.5"><span class="material-symbols-outlined text-[14px]">schedule</span> Hadir Setengah</span>`;
                } else if (item.status_hari_ini === 'Izin') {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300 gap-1.5"><span class="material-symbols-outlined text-[14px]">edit_document</span> ${item.status_hari_ini}</span>`;
                } else {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 gap-1.5"><span class="material-symbols-outlined text-[14px]">cancel</span> Tidak Hadir</span>`;
                }

                // Format Tanggal (untuk dikirim ke update function)
                const yyyy = selectedDate.getFullYear();
                const mm = String(selectedDate.getMonth() + 1).padStart(2, '0');
                const dd = String(selectedDate.getDate()).padStart(2, '0');
                const tglString = `${yyyy}-${mm}-${dd}`;

                // Susun baris TR
                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group";
                tr.innerHTML = `
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="size-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs uppercase">
                                ${item.nama.substring(0,2)}
                            </div>
                            <div>
                                <p class="font-semibold text-slate-900 dark:text-white">${item.nama}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        ${statusBadge}
                    </td>
                    <td class="px-6 py-4 text-center font-mono text-slate-600">
                        ${item.waktu_masuk ? item.waktu_masuk : '<span class="text-slate-400">--:--</span>'}
                    </td>
                    <td class="px-6 py-4 text-center font-mono text-slate-600">
                        ${item.waktu_pulang ? item.waktu_pulang : '<span class="text-slate-400">--:--</span>'}
                    </td>
                    <td class="px-6 py-4 text-right relative">
                        <!-- Dropdown Toggler -->
                        <button onclick="toggleActionMenu(${item.anggota_id})" class="p-1.5 text-slate-400 hover:text-primary transition-colors hover:bg-slate-100 rounded-lg">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="action-menu-${item.anggota_id}" class="hidden absolute right-6 top-10 bg-white border border-slate-200 shadow-xl rounded-xl w-40 py-1 z-50 overflow-hidden text-left">
                            <p class="text-[10px] font-bold text-slate-400 px-3 uppercase mt-1 mb-1">Ubah Status</p>
                            <button onclick="updateManualStatus(${item.anggota_id}, '${tglString}', 'Hadir Penuh')" class="w-full px-3 py-2 text-xs font-semibold hover:bg-slate-50 text-slate-700 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-green-500">check_circle</span> Hadir Penuh
                            </button>
                            <button onclick="updateManualStatus(${item.anggota_id}, '${tglString}', 'Hadir Setengah')" class="w-full px-3 py-2 text-xs font-semibold hover:bg-slate-50 text-slate-700 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-yellow-500">schedule</span> Hadir Setengah
                            </button>
                            <button onclick="updateManualStatus(${item.anggota_id}, '${tglString}', 'Izin')" class="w-full px-3 py-2 text-xs font-semibold hover:bg-slate-50 text-slate-700 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-purple-500">menu_book</span> Izin
                            </button>
                            <button onclick="updateManualStatus(${item.anggota_id}, '${tglString}', 'Tidak Hadir')" class="w-full px-3 py-2 text-xs font-semibold hover:bg-slate-50 text-slate-700 flex items-center gap-2 border-t mt-1">
                                <span class="material-symbols-outlined text-[16px] text-red-500">cancel</span> Tidak Hadir
                            </button>
                            <button onclick="deleteAttendanceLogs(${item.anggota_id}, '${tglString}', '${safeName}')" class="w-full px-3 py-2 text-xs font-bold hover:bg-red-50 text-red-600 flex items-center gap-2 border-t mt-1">
                                <span class="material-symbols-outlined text-[16px]">delete</span> Hapus Data
                            </button>
                        </div>
                    </td>
                `;
                elTableBody.appendChild(tr);
            });
        }

        // ==========================================
        // 🛠️ FUNGSI AKSI & UPDATE MANUAL
        // ==========================================
        let currentMenuOpen = null;

        function toggleActionMenu(id) {
            // Close old menu
            if (currentMenuOpen && currentMenuOpen !== `action-menu-${id}`) {
                document.getElementById(currentMenuOpen).classList.add('hidden');
            }
            
            // Toggle requested menu
            const menu = document.getElementById(`action-menu-${id}`);
            menu.classList.toggle('hidden');
            currentMenuOpen = menu.classList.contains('hidden') ? null : `action-menu-${id}`;
        }

        // Close menu if clicked outside
        document.addEventListener('click', function(e) {
            if (currentMenuOpen) {
                const btnClicked = e.target.closest('button[onclick^="toggleActionMenu"]');
                const menuClicked = e.target.closest('.absolute.bg-white'); // Action menu container
                
                if (!btnClicked && !menuClicked) {
                    document.getElementById(currentMenuOpen).classList.add('hidden');
                    currentMenuOpen = null;
                }
            }
        });

        function deleteAttendanceLogs(anggotaId, tanggal, nama) {
            // Close menu
            if(currentMenuOpen) document.getElementById(currentMenuOpen).classList.add('hidden');
            currentMenuOpen = null;

            openConfirmModal(
                'Hapus Data Kehadiran',
                `Anda yakin ingin menghapus <b>semua data pindaian</b> milik <b>${nama}</b> pada tanggal ${tanggal}? Tindakan ini tidak dapat dibatalkan.`,
                'Ya, Hapus Data',
                'bg-red-600 hover:bg-red-700 focus:ring-red-500',
                () => {
                    fetch("{{ url('api/attendance-logs') }}", {
                        method: "DELETE",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            anggota_id: anggotaId,
                            tanggal: tanggal
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.status === 'success') {
                            fetchHistoryData(selectedDate);
                        } else {
                            alert('Gagal menghapus data: ' + (data.message || 'Error'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Terjadi kesalahan jaringan.");
                    });
                }
            );
        }

        function updateManualStatus(anggotaId, tanggal, status) {
            // Close menu
            if(currentMenuOpen) document.getElementById(currentMenuOpen).classList.add('hidden');
            currentMenuOpen = null;

            openConfirmModal(
                'Ubah Status Kehadiran',
                `Anda yakin ingin mengubah status menjadi: <b>${status}</b>?`,
                'Ya, Ubah Status',
                'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
                () => {
                    // Memanggil API Backend (Laravel View -> API POST harus pakai CSRF kalau di session)
                    fetch("{{ url('api/update-status') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            anggota_id: anggotaId,
                            tanggal: tanggal,
                            status: status
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.status === 'success') {
                            fetchHistoryData(selectedDate);
                        } else {
                            alert('Gagal merubah status: ' + (data.message || 'Error'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Terjadi kesalahan jaringan.");
                    });
                }
            );
        }

        // ==========================================
        // 🔄 TAB NAVIGATION
        // ==========================================
        function switchTab(tabId) {
            const btnRekap = document.getElementById('btn-tab-rekap');
            const btnAnggota = document.getElementById('btn-tab-anggota');
            const tabRekap = document.getElementById('tab-rekap');
            const tabAnggota = document.getElementById('tab-anggota');

            if (tabId === 'rekap') {
                tabRekap.classList.remove('hidden');
                tabRekap.classList.add('grid');
                tabAnggota.classList.add('hidden');
                tabAnggota.classList.remove('flex');

                btnRekap.className = "px-4 py-2 bg-white dark:bg-slate-700 rounded-lg text-sm font-bold text-slate-900 dark:text-white shadow-sm transition-all flex items-center gap-2";
                btnAnggota.className = "px-4 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg text-sm font-medium transition-all flex items-center gap-2";
            } else {
                tabAnggota.classList.remove('hidden');
                tabAnggota.classList.add('flex');
                tabRekap.classList.add('hidden');
                tabRekap.classList.remove('grid');

                btnAnggota.className = "px-4 py-2 bg-white dark:bg-slate-700 rounded-lg text-sm font-bold text-slate-900 dark:text-white shadow-sm transition-all flex items-center gap-2";
                btnRekap.className = "px-4 py-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg text-sm font-medium transition-all flex items-center gap-2";

                loadAnggotaData();
            }
        }

        // ==========================================
        // 👥 FITUR KELOLA ANGGOTA
        // ==========================================
        const API_ANGGOTA_URL = "{{ url('api/anggota') }}";
        const elAnggotaTableBody = document.getElementById('anggota-table-body');
        
        function loadAnggotaData() {
            elAnggotaTableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Memuat anggota...</td></tr>`;
            fetch(API_ANGGOTA_URL)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        renderAnggotaTable(data.data);
                    }
                })
                .catch(err => {
                    console.error('Error fetching anggota:', err);
                    elAnggotaTableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-4 text-center text-red-500">Gagal memuat data.</td></tr>`;
                });
        }

        // Function membuat SVG Inisial secara lokal dengan Base64 untuk mencegah bentrok Quote(Kutip)
        const getSvgAvatar = (nama) => {
            const safeName = nama ? String(nama).trim() : "?";
            const initials = safeName.substring(0, 2).toUpperCase();
            const svg = `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" width="200" height="200"><rect width="100" height="100" fill="#2463eb"/><text x="50" y="50" font-family="Inter, sans-serif" font-size="40" font-weight="bold" fill="#ffffff" text-anchor="middle" dominant-baseline="central">${initials}</text></svg>`;
            // Convert to Base64 to remove all arbitrary quotes problem on HTML Attributes
            const base64Svg = btoa(unescape(encodeURIComponent(svg)));
            return `data:image/svg+xml;base64,${base64Svg}`;
        };

        function renderAnggotaTable(dataArray) {
            elAnggotaTableBody.innerHTML = '';
            
            if (dataArray.length === 0) {
                 elAnggotaTableBody.innerHTML = `<tr><td colspan="4" class="px-6 py-8 text-center text-slate-500">Belum ada anggota terdaftar.</td></tr>`;
                 return;
            }

            dataArray.forEach((item, index) => {
                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group";
                
                // Melindungi Nama dari XSS dan Syntax Error Kutip HTML
                const safeName = item.nama ? String(item.nama).replace(/"/g, '&quot;').replace(/'/g, '&#39;') : "Tanpa Nama";

                // QR Source rendering via API qrserver
                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=500x500&data=${encodeURIComponent(item.qr_code_token)}`;
                
                // Cek Foto (Jika null, fallback menggunakan dinamis inisial SVG Base64)
                const fotoSrc = item.foto && item.foto !== "" 
                                ? `{{ asset('') }}${item.foto}` 
                                : getSvgAvatar(item.nama);

                tr.innerHTML = `
                    <td class="px-6 py-4 text-center text-slate-500 font-medium border-r border-slate-100 dark:border-slate-800/60">${index + 1}</td>
                    <td class="px-6 py-4 border-r border-slate-100 dark:border-slate-800/60">
                        <div class="flex items-center gap-4">
                            <!-- Foto Thumbnail (menggunakan attr data- untuk menghindari error kutip pada JS string parameter) -->
                            <button data-id="${item.id}" data-nama="${safeName}" data-foto="${fotoSrc}" onclick="openModalFoto(this.dataset.id, this.dataset.nama, this.dataset.foto)" class="shrink-0 size-12 sm:size-14 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden border-2 border-slate-200 dark:border-slate-700 hover:border-primary transition-colors focus:ring-2 focus:ring-primary focus:outline-none" title="Ubah/Lihat Foto">
                                <img src="${fotoSrc}" alt="Foto ${safeName}" class="w-full h-full object-cover">
                            </button>
                            <!-- Nama dan ID -->
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-900 dark:text-white text-base">${safeName}</span>
                                <span class="text-xs text-slate-400 font-mono mt-0.5" title="String QR Token Penuh: ${item.qr_code_token}">ID Token: <span class="text-slate-500 dark:text-slate-300">${item.qr_code_token.substring(0, 12)}...</span></span>
                            </div>
                        </div>
                    </td>
                    <td class="px-3 sm:px-6 py-4 text-center">
                        <button data-nama="${safeName}" data-qr="${item.qr_code_token}" data-url="${qrUrl}" onclick="openModalQR(this.dataset.nama, this.dataset.qr, this.dataset.url)" title="Perbesar QR Code" class="p-1 sm:p-2 bg-white border border-slate-200 shadow-sm rounded-xl hover:scale-105 hover:border-primary focus:ring-2 focus:ring-primary focus:outline-none transition-all cursor-pointer">
                            <img src="${qrUrl}" alt="QR Code" class="size-14 sm:size-20 lg:size-24 rounded-lg mix-blend-multiply object-contain bg-white" />
                        </button>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button data-id="${item.id}" data-nama="${safeName}" onclick="deleteAnggota(this.dataset.id, this.dataset.nama)" title="Hapus Anggota" class="p-2 text-slate-400 hover:text-red-600 transition-colors hover:bg-red-50 dark:hover:bg-red-900/40 rounded-lg group-hover:opacity-100 sm:opacity-50">
                            <span class="material-symbols-outlined text-[20px]">delete</span>
                        </button>
                    </td>
                `;
                elAnggotaTableBody.appendChild(tr);
            });
        }

        function openModalTambah() {
            const modal = document.getElementById('modal-tambah');
            const content = document.getElementById('modal-tambah-content');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Animasi in
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.getElementById('input-nama-anggota').focus();
        }

        function closeModalTambah() {
            const modal = document.getElementById('modal-tambah');
            const content = document.getElementById('modal-tambah-content');
            // Animasi out
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.getElementById('form-tambah-anggota').reset();
            }, 200);
        }

        function submitFormTambah(e) {
            e.preventDefault();
            const btn = document.getElementById('btn-submit-anggota');
            const nama = document.getElementById('input-nama-anggota').value;
            const fileInput = document.getElementById('input-foto-anggota');

            if(!nama) return;

            // Buat Form Data krn ada upload file
            let formData = new FormData();
            formData.append('nama', nama);
            if(fileInput.files.length > 0) {
                formData.append('foto', fileInput.files[0]);
            }

            btn.disabled = true;
            btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Menyimpan...`;

            fetch(API_ANGGOTA_URL, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData // Body ini tidak usah JSON kalo pake FormData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    closeModalTambah();
                    loadAnggotaData();
                } else {
                    alert('Gagal menambah anggota: ' + (data.message || 'Error'));
                }
            })
            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan jaringan.");
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">app_registration</span> Daftarkan & Buat QR`;
            });
        }

        // ==========================================
        // 🖼️ MODUS PREVIEW FOTO + ZOOM QR
        // ==========================================
        function openModalFoto(id, nama, fotoSrc) {
            const modal = document.getElementById('modal-foto');
            const content = document.getElementById('modal-foto-content');
            
            document.getElementById('preview-foto-nama').textContent = nama;
            document.getElementById('preview-foto-img').src = fotoSrc;
            document.getElementById('update-foto-id').value = id;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModalFoto() {
            const modal = document.getElementById('modal-foto');
            const content = document.getElementById('modal-foto-content');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.getElementById('form-update-foto').reset();
                document.getElementById('file-name-display').textContent = 'Pilih Foto Baru...';
            }, 200);
        }

        function submitFormUpdateFoto(e) {
            e.preventDefault();
            const id = document.getElementById('update-foto-id').value;
            const fileInput = document.getElementById('update-foto-file');
            const btn = document.getElementById('btn-submit-foto');

            if(!fileInput.files.length) return;

            btn.disabled = true;
            btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Mengunggah...`;

            let formData = new FormData();
            formData.append('foto', fileInput.files[0]);

            fetch(`${API_ANGGOTA_URL}/${id}/foto`, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    closeModalFoto();
                    loadAnggotaData();
                } else {
                    alert('Gagal update foto: ' + (data.message || 'Error'));
                }
            })
            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan jaringan saat upload.");
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">save</span> Simpan Foto`;
            });
        }

        function deleteFotoAnggota() {
            const id = document.getElementById('update-foto-id').value;
            const btn = document.getElementById('btn-hapus-foto');

            openConfirmModal(
                'Hapus Foto Profil',
                'Anda yakin ingin menghapus foto profil ini dan kembali menggunakan inisial bawaan?',
                'Ya, Hapus Foto',
                'bg-red-600 hover:bg-red-700 focus:ring-red-500',
                () => {
                    btn.disabled = true;
                    btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Menghapus...`;

                    fetch(`${API_ANGGOTA_URL}/${id}/foto`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.status === 'success') {
                            closeModalFoto();
                            loadAnggotaData();
                        } else {
                            alert('Gagal menghapus foto: ' + (data.message || 'Error'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Terjadi kesalahan jaringan saat menghapus foto.");
                    })
                    .finally(() => {
                        btn.disabled = false;
                        btn.innerHTML = `<span class="material-symbols-outlined text-[18px]">delete</span> Hapus Foto`;
                    });
                }
            );
        }

        // QR Code Zoom Modal
        function openModalQR(nama, token, srcUrl) {
            const modal = document.getElementById('modal-qr');
            const content = document.getElementById('modal-qr-content');
            
            document.getElementById('zoom-qr-nama').textContent = nama;
            document.getElementById('zoom-qr-token').textContent = token;
            document.getElementById('zoom-qr-img').src = srcUrl;
            
            // Setup fitur Download Paksa (Force Download Image API eksternal tanpa mengarahkan tab baru)
            const btnDown = document.getElementById('btn-download-qr');
            
            // Hapus event click sebelumnya jika ada (menggunakan cloneNode hack cepat)
            const newBtn = btnDown.cloneNode(true);
            btnDown.parentNode.replaceChild(newBtn, btnDown);
            
            newBtn.onclick = function(e) {
                e.preventDefault();
                
                // Ubah teks saat mengunduh
                const originalHTML = newBtn.innerHTML;
                newBtn.innerHTML = '<span class="material-symbols-outlined text-lg animate-spin">progress_activity</span> Mengunduh...';
                newBtn.style.pointerEvents = 'none';

                fetch(srcUrl)
                    .then(response => response.blob())
                    .then(blob => {
                        // Buat link URL sementara (virtual)
                        const blobUrl = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.style.display = 'none';
                        a.href = blobUrl;
                        // Format Profesional: QRCode_Siabsen_[Nama_Anggota]_[ID].jpg
                        const safeNama = nama.trim().replace(/\s+/g, '_').replace(/[^a-zA-Z0-9_]/g, '');
                        a.download = `QRCode_Siabsen_${safeNama}_${token.substring(0, 8)}.jpg`;
                        
                        document.body.appendChild(a);
                        a.click();
                        
                        window.URL.revokeObjectURL(blobUrl);
                        document.body.removeChild(a);
                    })
                    .catch(() => alert('Gagal mengunduh QR Code. Pastikan koneksi internet stabil.'))
                    .finally(() => {
                        newBtn.innerHTML = originalHTML;
                        newBtn.style.pointerEvents = 'auto';
                    });
            };

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModalQR() {
            const modal = document.getElementById('modal-qr');
            const content = document.getElementById('modal-qr-content');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            const backdrop = document.getElementById('mobile-menu-backdrop');
            const drawer = document.getElementById('mobile-menu-drawer');
            
            if (menu.classList.contains('hidden')) {
                // Show sequence
                menu.classList.remove('hidden');
                menu.classList.add('block', 'pointer-events-auto');
                menu.classList.remove('pointer-events-none');
                
                // Allow browser to render display:block before starting animation
                setTimeout(() => {
                    backdrop.classList.remove('opacity-0');
                    backdrop.classList.add('opacity-100');
                    drawer.classList.remove('-translate-x-full');
                    drawer.classList.add('translate-x-0');
                }, 10);
            } else {
                // Hide sequence
                backdrop.classList.remove('opacity-100');
                backdrop.classList.add('opacity-0');
                drawer.classList.remove('translate-x-0');
                drawer.classList.add('-translate-x-full');
                
                // Set hidden after animation finishes (300ms)
                setTimeout(() => {
                    menu.classList.add('hidden', 'pointer-events-none');
                    menu.classList.remove('block', 'pointer-events-auto');
                }, 300);
            }
        }

        function deleteAnggota(id, nama) {
            openConfirmModal(
                'Hapus Data Anggota',
                `PERHATIAN: Hapus data anggota <b>"${nama}"</b>?<br>Tindakan ini permanen dan akan menghapus anggota secara permanen. Lanjutkan?`,
                'Hapus Permanen',
                'bg-red-600 hover:bg-red-700 focus:ring-red-500',
                () => {
                    fetch(API_ANGGOTA_URL + '/' + id, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.status === 'success') {
                            loadAnggotaData();
                        } else {
                            alert('Gagal menghapus anggota: ' + (data.message || 'Error'));
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert("Terjadi kesalahan jaringan.");
                    });
                }
            );
        }
    </script>
</body>
</html>
