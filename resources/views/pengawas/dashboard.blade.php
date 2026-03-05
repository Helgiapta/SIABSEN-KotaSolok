<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard Pengawas - Siabsen Kota Solok</title>
    <meta name="theme-color" content="#0F4C75"/>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/siabsenlogotrs.png') }}" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        if (localStorage.theme === 'dark') {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }

        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "rgb(var(--color-primary) / <alpha-value>)",
                        "primary-light": "rgb(var(--color-primary-light) / <alpha-value>)",
                        "primary-dark": "#1B262C",
                        "primary-100": "rgb(var(--color-primary-100) / <alpha-value>)",
                        "background-light": "#f6f6f8",
                        "background-dark": "#121A1E",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1B262C",
                        "slate": {
                            800: "rgb(var(--color-slate-800) / <alpha-value>)",
                            900: "rgb(var(--color-slate-900) / <alpha-value>)"
                        }
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
    <style>
        :root {
            --color-primary: 15 76 117;
            --color-primary-light: 50 130 184;
            --color-primary-100: 187 225 250;
            --color-slate-800: 30 41 59;
            --color-slate-900: 15 23 42;
        }
        .dark {
            --color-primary: 95 133 219;
            --color-primary-light: 144 184 248;
            --color-primary-100: 38 40 43;
            --color-slate-800: 53 57 65;
            --color-slate-900: 38 40 43;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-display min-h-screen flex flex-col">
    <!-- Top Navigation -->
    <header class="bg-white/60 dark:bg-slate-900/60 backdrop-blur-xl border-b border-white/50 dark:border-slate-800 sticky top-0 z-50">
        <div class="w-full max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16 sm:h-20">
            <div class="flex items-center gap-3">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 sm:h-12 sm:w-12 bg-blue-500/10 rounded-lg p-1 flex items-center justify-center shrink-0">
                        <img src="{{ asset('assets/images/siabsenlogo.png') }}" alt="Logo" class="w-full h-full object-contain filter drop-shadow-sm">
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold tracking-tight text-slate-900 dark:text-white truncate">Pengawas SIABSEN</h1>
                        <span class="hidden sm:inline-block text-[10px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300 px-2 py-0.5 rounded-full uppercase tracking-wider">Mode Pengawas</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-6">
                <button onclick="toggleTheme()" class="p-2 text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary-light transition-colors rounded-xl bg-slate-100 dark:bg-slate-800 flex-shrink-0" title="Toggle Theme">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                </button>
                <div class="hidden lg:flex gap-3">
                    <a href="{{ route('public.dashboard') }}" class="flex items-center gap-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 px-4 py-2.5 rounded-xl font-bold text-sm transition-colors border border-slate-200 dark:border-slate-700">
                        <span class="material-symbols-outlined text-xl">public</span>
                        <span>Dashboard Publik</span>
                    </a>
                    <a href="{{ route('pengawas.scanner') }}" class="flex items-center gap-2 bg-primary hover:bg-primary-light text-white px-4 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-primary-light/30 transition-all hover:shadow-primary-light/50 hover:-translate-y-0.5">
                        <span class="material-symbols-outlined text-xl">qr_code_scanner</span>
                        <span>BUKA SCANNER</span>
                    </a>
                </div>

                <!-- User Profile & Logout -->
                <div class="flex items-center gap-3 sm:pl-6 sm:border-l border-slate-200 dark:border-slate-700">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-slate-900 dark:text-white truncate max-w-[120px]">{{ auth()->user()->name ?? 'Pengawas' }}</p>
                        <p class="text-[10px] text-amber-600 dark:text-amber-400 font-bold">Selamat Datang</p>
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
    </header>

    <main class="flex-1 w-full max-w-[1600px] mx-auto p-4 sm:p-6 lg:p-8 flex flex-col gap-8">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-2">
            <div class="text-center lg:text-left">
                <h2 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-white tracking-tight">Dashboard Pengawas</h2>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">Pantau dan rekap data presensi harian anggota</p>
            </div>
        </div>

        <!-- Rekap Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="relative group">
                <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700 rounded-3xl translate-y-1.5 translate-x-1.5 transition-transform md:hover:translate-y-2.5 md:hover:translate-x-2.5"></div>
                <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md p-5 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 flex lg:flex-col items-center lg:items-start gap-4 lg:gap-0 transition-transform md:hover:-translate-y-1 md:hover:-translate-x-1">
                    <div class="p-2.5 bg-primary-100 dark:bg-slate-700 text-primary dark:text-primary-light rounded-2xl mb-2">
                        <span class="material-symbols-outlined text-2xl">how_to_reg</span>
                    </div>
                    <div class="flex flex-col">
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Total Hadir</span>
                        <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tight" id="stat-hadir">0 <span class="text-sm font-normal text-slate-400">/ 0</span></p>
                    </div>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute inset-0 bg-blue-100/60 dark:bg-slate-700/50 rounded-3xl translate-y-1.5 translate-x-1.5 transition-transform md:group-hover:translate-y-2.5 md:group-hover:translate-x-2.5"></div>
                <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md p-5 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-blue-900/5 flex lg:flex-col items-center lg:items-start gap-4 lg:gap-0 transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                    <div class="p-2.5 bg-blue-50 dark:bg-slate-900/50 text-blue-500 rounded-2xl mb-2">
                        <span class="material-symbols-outlined text-2xl">assignment_late</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Izin</span>
                        <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tight" id="stat-izin">0 <span class="text-sm font-normal text-slate-400">org</span></p>
                    </div>
                </div>
            </div>
            <div class="relative group">
                <div class="absolute inset-0 bg-red-100/60 dark:bg-slate-700/50 rounded-3xl translate-y-1.5 translate-x-1.5 transition-transform md:group-hover:translate-y-2.5 md:group-hover:translate-x-2.5"></div>
                <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md p-5 rounded-3xl border border-white dark:border-slate-700 shadow-xl shadow-red-900/5 flex lg:flex-col items-center lg:items-start gap-4 lg:gap-0 transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                    <div class="p-2.5 bg-red-50 dark:bg-slate-900/50 text-red-500 rounded-2xl mb-2">
                        <span class="material-symbols-outlined text-2xl">person_off</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-300 uppercase tracking-wider">Tanpa Ket.</span>
                        <p class="text-3xl font-black text-slate-800 dark:text-white tracking-tight" id="stat-absen">0 <span class="text-sm font-normal text-slate-400">org</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kalender + Riwayat Kehadiran -->
        <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
            <!-- Kiri: Kalender -->
            <div class="xl:col-span-4">
                <div class="relative group flex-1 min-h-[400px]">
                    <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700 rounded-[2rem] translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
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
                                <div class="text-center text-[10px] font-bold text-slate-500 dark:text-slate-300 uppercase py-2">Sen</div>
                                <div class="text-center text-[10px] font-bold text-slate-500 dark:text-slate-300 uppercase py-2">Sel</div>
                                <div class="text-center text-[10px] font-bold text-slate-500 dark:text-slate-300 uppercase py-2">Rab</div>
                                <div class="text-center text-[10px] font-bold text-slate-500 dark:text-slate-300 uppercase py-2">Kam</div>
                                <div class="text-center text-[10px] font-bold text-slate-500 dark:text-slate-300 uppercase py-2">Jum</div>
                                <div class="text-center text-[10px] font-bold text-slate-500 dark:text-slate-300 uppercase py-2">Sab</div>
                            </div>
                            <div class="grid grid-cols-7 gap-y-2 gap-x-2 flex-1" id="calendar-grid"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kanan: Riwayat Kehadiran -->
            <div class="xl:col-span-8 flex flex-col gap-6">
                <div class="relative group h-full flex flex-col">
                    <div class="absolute inset-0 bg-slate-200/60 dark:bg-slate-700/50 rounded-[2rem] translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                    <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-[2rem] border border-white dark:border-slate-700 shadow-xl shadow-slate-900/5 overflow-x-clip flex flex-col h-full transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">

                        <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800/50 flex flex-col gap-4">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                                <div>
                                    <h3 class="font-black text-xl text-primary-dark dark:text-white flex items-center gap-3">
                                        <span class="p-2 bg-slate-100 dark:bg-slate-900/50 rounded-xl text-slate-600 material-symbols-outlined">history</span>
                                        Riwayat Kehadiran
                                    </h3>
                                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-200 mt-1 sm:ml-12">Tanggal Terpilih: <span class="font-bold text-primary dark:text-primary-light" id="selected-date-text">-</span></p>
                                </div>
                                <div class="relative w-full sm:w-64">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px]">search</span>
                                    <input id="search-input" class="w-full pl-10 pr-4 py-2.5 text-sm border border-slate-200 dark:border-slate-700 rounded-xl bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary transition-all" placeholder="Cari nama anggota..." type="text"/>
                                </div>
                            </div>
                            <!-- Filter chips -->
                            <div class="flex flex-wrap gap-2 items-center">
                                <span class="text-[10px] font-bold text-slate-600 dark:text-slate-200 uppercase tracking-widest shrink-0">Filter Status:</span>
                                <button data-astatus="" onclick="setStatusFilter(this)" class="filter-status active-filter px-3 py-1 rounded-full text-xs font-bold border border-primary bg-primary text-white transition-all">Semua</button>
                                <button data-astatus="Hadir Penuh" onclick="setStatusFilter(this)" class="filter-status px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white dark:bg-slate-700 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:border-green-500 hover:text-green-600 transition-all">Hadir Penuh</button>
                                <button data-astatus="Hadir Setengah" onclick="setStatusFilter(this)" class="filter-status px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white dark:bg-slate-700 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:border-yellow-500 hover:text-yellow-600 transition-all">Hadir Setengah</button>
                                <button data-astatus="Izin" onclick="setStatusFilter(this)" class="filter-status px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white dark:bg-slate-700 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:border-blue-500 hover:text-blue-600 transition-all">Izin</button>
                                <button data-astatus="Sakit" onclick="setStatusFilter(this)" class="filter-status px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white dark:bg-slate-700 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:border-teal-500 hover:text-teal-600 transition-all">Sakit</button>
                                <button data-astatus="Tidak Hadir" onclick="setStatusFilter(this)" class="filter-status px-3 py-1 rounded-full text-xs font-bold border border-slate-200 bg-white dark:bg-slate-700 dark:border-slate-600 text-slate-600 dark:text-slate-300 hover:border-red-500 hover:text-red-600 transition-all">Tidak Hadir</button>
                            </div>
                        </div>

                        <div class="w-full overflow-x-auto overflow-y-auto max-h-[520px] flex-1">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-slate-50/50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-300 text-[10px] sm:text-xs font-bold uppercase tracking-widest sticky top-0 z-10">
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
        </div>
    </main>

    <!-- Modal Konfirmasi -->
    <div id="modal-confirm" class="fixed inset-0 z-[110] hidden flex-col items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[4px]" onclick="closeConfirmModal()"></div>
        <div class="relative w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0" id="modal-confirm-content">
            <div id="confirm-pastel-layer" class="absolute inset-0 bg-red-100/40 dark:bg-red-900/30 rounded-[2.5rem] translate-y-3 translate-x-3 transition-colors duration-300"></div>
            <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white/50 dark:border-slate-700 shadow-2xl">
                <div class="flex flex-col items-center text-center">
                    <div id="confirm-icon-wrapper" class="p-4 bg-red-50 dark:bg-red-900/30 text-red-500 rounded-3xl mb-6 transition-colors duration-300">
                        <span id="confirm-icon" class="material-symbols-outlined text-4xl">warning</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 dark:text-white mb-3 tracking-tight" id="confirm-title">Konfirmasi</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-8 leading-relaxed font-medium" id="confirm-message">Apakah Anda yakin?</p>
                    <div class="flex flex-col-reverse sm:flex-row gap-3 w-full">
                        <button type="button" onclick="closeConfirmModal()" class="flex-1 py-4 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-200 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">Batal</button>
                        <button type="button" id="btn-confirm-action" onclick="executeConfirm()" class="flex-[1.5] py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-white shadow-xl transition-all hover:-translate-y-1 focus:ring-4 focus:outline-none">
                            Ya, Lanjutkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let confirmCallback = null;

        function openConfirmModal(title, message, btnText, btnColorClass, callback) {
            const modal   = document.getElementById('modal-confirm');
            const content = document.getElementById('modal-confirm-content');
            const layer   = document.getElementById('confirm-pastel-layer');
            const iconWrap= document.getElementById('confirm-icon-wrapper');
            const icon    = document.getElementById('confirm-icon');

            document.getElementById('confirm-title').textContent   = title;
            document.getElementById('confirm-message').innerHTML    = message;

            const isRed = btnColorClass.includes('bg-red');
            if (isRed) {
                layer.className    = "absolute inset-0 bg-red-100/40 dark:bg-red-900/30 rounded-[2.5rem] translate-y-3 translate-x-3 transition-colors duration-300";
                iconWrap.className = "p-4 bg-red-50 dark:bg-red-900/40 text-red-500 rounded-3xl mb-6 transition-colors duration-300";
                icon.textContent   = "warning";
            } else {
                layer.className    = "absolute inset-0 bg-primary-100/40 dark:bg-slate-700/50 rounded-[2.5rem] translate-y-3 translate-x-3 transition-colors duration-300";
                iconWrap.className = "p-4 bg-primary-50 dark:bg-primary-900/30 text-primary rounded-3xl mb-6 transition-colors duration-300";
                icon.textContent   = "info";
            }

            const btn = document.getElementById('btn-confirm-action');
            btn.textContent = btnText;
            btn.className = `flex-[1.5] py-4 rounded-2xl font-black text-xs uppercase tracking-widest text-white shadow-xl transition-all hover:-translate-y-1 focus:ring-4 focus:outline-none ${btnColorClass}`;

            confirmCallback = callback;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeConfirmModal() {
            const modal   = document.getElementById('modal-confirm');
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
            if (confirmCallback) confirmCallback();
            closeConfirmModal();
        }

        // API URLs (Pengawas)
        const API_HISTORY_URL = "{{ url('pengawas/api/history-attendance') }}";

        let currentDate        = new Date();
        let selectedDate       = new Date();
        let currentHistoryData = [];
        let statusFilter       = '';
        let currentMenuOpen    = null;

        const elCalendarGrid       = document.getElementById('calendar-grid');
        const elCalendarHeader     = document.getElementById('calendar-header');
        const elSelectedDateText   = document.getElementById('selected-date-text');
        const elTableBody          = document.getElementById('history-table-body');
        const elSearchInput        = document.getElementById('search-input');
        const elStatHadir          = document.getElementById('stat-hadir');
        const elStatAbsen          = document.getElementById('stat-absen');
        const elStatIzin           = document.getElementById('stat-izin');

        document.addEventListener('DOMContentLoaded', () => {
            renderCalendar();
            fetchHistoryData(selectedDate);

            document.getElementById('btn-prev-month').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });
            document.getElementById('btn-next-month').addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            elSearchInput.addEventListener('input', (e) => {
                renderTable(currentHistoryData, e.target.value.toLowerCase());
            });
        });

        function setStatusFilter(btn) {
            statusFilter = btn.dataset.astatus;
            document.querySelectorAll('.filter-status').forEach(b => {
                b.classList.remove('active-filter', 'bg-primary', 'text-white', 'border-primary');
                b.classList.add('border-slate-200', 'bg-white', 'dark:bg-slate-700');
            });
            btn.classList.add('active-filter', 'bg-primary', 'text-white', 'border-primary');
            btn.classList.remove('border-slate-200', 'bg-white', 'dark:bg-slate-700');
            renderTable(currentHistoryData, elSearchInput.value.toLowerCase());
        }

        function renderCalendar() {
            const year  = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const monthNames = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
            elCalendarHeader.textContent = `${monthNames[month]} ${year}`;
            elCalendarGrid.innerHTML = '';

            const firstDay    = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                const emptyDiv = document.createElement('div');
                emptyDiv.className = 'aspect-square flex items-center justify-center';
                elCalendarGrid.appendChild(emptyDiv);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const targetDateObj = new Date(year, month, day);
                const btn = document.createElement('button');
                btn.className = `aspect-square flex flex-col items-center justify-center rounded-lg relative group transition-colors `;

                if (targetDateObj.toDateString() === selectedDate.toDateString()) {
                    btn.className += `bg-primary text-white shadow-lg shadow-primary/30`;
                    btn.innerHTML = `<span class="text-sm font-bold">${day}</span>`;
                } else {
                    btn.className += `md:hover:bg-slate-50 dark:md:hover:bg-slate-800 text-slate-700 dark:text-slate-300`;
                    btn.innerHTML = `<span class="text-sm font-medium">${day}</span>`;
                }

                const today = new Date();
                if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear() && targetDateObj.toDateString() !== selectedDate.toDateString()) {
                    btn.classList.add('border-2', 'border-primary', 'font-bold');
                }

                btn.onclick = () => {
                    selectedDate = new Date(year, month, day);
                    renderCalendar();
                    fetchHistoryData(selectedDate);
                };
                elCalendarGrid.appendChild(btn);
            }
        }

        function fetchHistoryData(dateObj) {
            const yyyy = dateObj.getFullYear();
            const mm   = String(dateObj.getMonth() + 1).padStart(2, '0');
            const dd   = String(dateObj.getDate()).padStart(2, '0');
            const formattedDate = `${yyyy}-${mm}-${dd}`;

            const options = { weekday:'long', year:'numeric', month:'long', day:'numeric' };
            elSelectedDateText.textContent = dateObj.toLocaleDateString('id-ID', options);

            elTableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-12 text-center text-slate-500">Memuat data absen tanggal ${formattedDate}...</td></tr>`;

            fetch(`${API_HISTORY_URL}?date=${formattedDate}`)
                .then(res => res.json())
                .then(data => {
                    currentHistoryData = data.data || [];
                    const totalAnggota = data.total_anggota || 0;
                    const hadir = (data.statistik.hadir_penuh || 0) + (data.statistik.hadir_setengah || 0);
                    const izin  = data.statistik.izin || 0;
                    const absen = totalAnggota - hadir - izin;

                    elStatHadir.innerHTML = `${hadir} <span class="text-xs font-normal text-slate-400">/ ${totalAnggota}</span>`;
                    elStatIzin.innerHTML  = `${izin} <span class="text-xs font-normal text-slate-400">org</span>`;
                    elStatAbsen.innerHTML = `${absen >= 0 ? absen : 0} <span class="text-xs font-normal text-slate-400">org</span>`;

                    renderTable(currentHistoryData, elSearchInput.value.toLowerCase());
                })
                .catch(err => {
                    console.error('Error:', err);
                    elTableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-4 text-center text-red-500">Gagal memuat data.</td></tr>`;
                });
        }

        function renderTable(dataArray, searchTerm = '') {
            elTableBody.innerHTML = '';

            let filtered = dataArray;
            if (searchTerm) {
                filtered = filtered.filter(item => item.nama.toLowerCase().includes(searchTerm));
            }
            if (statusFilter) {
                filtered = filtered.filter(item => item.status_hari_ini === statusFilter);
            }

            if (filtered.length === 0) {
                elTableBody.innerHTML = `<tr><td colspan="5" class="px-6 py-8 text-center text-slate-500">Tidak ada data yang cocok.</td></tr>`;
                return;
            }

            filtered.forEach(item => {
                const safeName = item.nama ? String(item.nama).replace(/"/g, '&quot;').replace(/'/g, '&#39;') : "Tanpa Nama";

                let statusBadge = '';
                if (item.status_hari_ini === 'Hadir Penuh') {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 gap-1.5"><span class="material-symbols-outlined text-[14px]">check_circle</span> Hadir Penuh</span>`;
                } else if (item.status_hari_ini === 'Hadir Setengah') {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 gap-1.5"><span class="material-symbols-outlined text-[14px]">schedule</span> Hadir Setengah</span>`;
                } else if (item.status_hari_ini === 'Izin') {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300 gap-1.5"><span class="material-symbols-outlined text-[14px]">edit_document</span> Izin</span>`;
                } else if (item.status_hari_ini === 'Sakit') {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-teal-100 text-teal-800 dark:bg-teal-900/30 dark:text-teal-300 gap-1.5"><span class="material-symbols-outlined text-[14px]">medical_services</span> Sakit</span>`;
                } else {
                    statusBadge = `<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 gap-1.5"><span class="material-symbols-outlined text-[14px]">cancel</span> Tidak Hadir</span>`;
                }

                const yyyy = selectedDate.getFullYear();
                const mm   = String(selectedDate.getMonth() + 1).padStart(2, '0');
                const dd   = String(selectedDate.getDate()).padStart(2, '0');
                const tglString = `${yyyy}-${mm}-${dd}`;

                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group";
                tr.innerHTML = `
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="size-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs uppercase">
                                ${item.nama.substring(0,2)}
                            </div>
                            <p class="font-semibold text-slate-900 dark:text-white">${item.nama}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">${statusBadge}</td>
                    <td class="px-6 py-4 text-center font-mono text-slate-600 dark:text-slate-300">
                        ${item.waktu_masuk ? item.waktu_masuk : '<span class="text-slate-400">--:--</span>'}
                    </td>
                    <td class="px-6 py-4 text-center font-mono text-slate-600 dark:text-slate-300">
                        ${item.waktu_pulang ? item.waktu_pulang : '<span class="text-slate-400">--:--</span>'}
                    </td>
                    <td class="px-6 py-4 text-right relative">
                        <button onclick="toggleActionMenu(${item.anggota_id})" class="p-1.5 text-slate-400 hover:text-primary transition-colors hover:bg-slate-100 rounded-lg">
                            <span class="material-symbols-outlined">more_vert</span>
                        </button>
                        <div id="action-menu-${item.anggota_id}" class="hidden absolute right-6 top-10 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl rounded-xl w-44 py-1 z-50 overflow-hidden text-left">
                            <p class="text-[10px] font-bold text-slate-400 px-3 uppercase mt-1 mb-1">Ubah Status</p>
                            <button onclick="updateManualStatus(${item.anggota_id}, '${tglString}', 'Hadir Penuh')" class="w-full px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-green-500">check_circle</span> Hadir Penuh
                            </button>
                            <button onclick="updateManualStatus(${item.anggota_id}, '${tglString}', 'Hadir Setengah')" class="w-full px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-yellow-500">schedule</span> Hadir Setengah
                            </button>
                            <button onclick="updateManualStatus(${item.anggota_id}, '${tglString}', 'Izin')" class="w-full px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-purple-500">menu_book</span> Izin
                            </button>
                            <button onclick="updateManualStatus(${item.anggota_id}, '${tglString}', 'Sakit')" class="w-full px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center gap-2">
                                <span class="material-symbols-outlined text-[16px] text-teal-500">medical_services</span> Sakit
                            </button>
                            <button onclick="updateManualStatus(${item.anggota_id}, '${tglString}', 'Tidak Hadir')" class="w-full px-3 py-2 text-xs font-semibold hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 flex items-center gap-2 border-t border-slate-100 dark:border-slate-700 mt-1">
                                <span class="material-symbols-outlined text-[16px] text-red-500">cancel</span> Tidak Hadir
                            </button>
                            <button onclick="deleteAttendanceLogs(${item.anggota_id}, '${tglString}', '${safeName}')" class="w-full px-3 py-2 text-xs font-bold hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 flex items-center gap-2 border-t border-slate-100 dark:border-slate-700 mt-1">
                                <span class="material-symbols-outlined text-[16px]">delete</span> Hapus Data
                            </button>
                        </div>
                    </td>
                `;
                elTableBody.appendChild(tr);
            });
        }

        function toggleActionMenu(id) {
            if (currentMenuOpen && currentMenuOpen !== `action-menu-${id}`) {
                document.getElementById(currentMenuOpen).classList.add('hidden');
            }
            const menu = document.getElementById(`action-menu-${id}`);
            menu.classList.toggle('hidden');
            currentMenuOpen = menu.classList.contains('hidden') ? null : `action-menu-${id}`;
        }

        document.addEventListener('click', function(e) {
            if (currentMenuOpen) {
                const btnClicked  = e.target.closest('button[onclick^="toggleActionMenu"]');
                const menuClicked = e.target.closest(`#${currentMenuOpen}`);
                if (!btnClicked && !menuClicked) {
                    document.getElementById(currentMenuOpen).classList.add('hidden');
                    currentMenuOpen = null;
                }
            }
        });

        function updateManualStatus(anggotaId, tanggal, status) {
            if (currentMenuOpen) { document.getElementById(currentMenuOpen).classList.add('hidden'); currentMenuOpen = null; }

            openConfirmModal(
                'Ubah Status Kehadiran',
                `Anda yakin ingin mengubah status menjadi: <b>${status}</b>?`,
                'Ya, Ubah Status',
                'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
                () => {
                    fetch("{{ url('pengawas/api/update-status') }}", {
                        method: "POST",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ anggota_id: anggotaId, tanggal: tanggal, status: status })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            fetchHistoryData(selectedDate);
                        } else {
                            alert('Gagal merubah status: ' + (data.message || 'Error'));
                        }
                    })
                    .catch(err => { console.error(err); alert("Kesalahan jaringan."); });
                }
            );
        }

        function deleteAttendanceLogs(anggotaId, tanggal, nama) {
            if (currentMenuOpen) { document.getElementById(currentMenuOpen).classList.add('hidden'); currentMenuOpen = null; }

            openConfirmModal(
                'Hapus Data Kehadiran',
                `Anda yakin ingin menghapus <b>semua data pindaian</b> milik <b>${nama}</b> pada tanggal ${tanggal}?`,
                'Ya, Hapus Data',
                'bg-red-600 hover:bg-red-700 focus:ring-red-500',
                () => {
                    fetch("{{ url('pengawas/api/attendance-logs') }}", {
                        method: "DELETE",
                        headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                        body: JSON.stringify({ anggota_id: anggotaId, tanggal: tanggal })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.status === 'success') {
                            fetchHistoryData(selectedDate);
                        } else {
                            alert('Gagal menghapus data: ' + (data.message || 'Error'));
                        }
                    })
                    .catch(err => { console.error(err); alert("Kesalahan jaringan."); });
                }
            );
        }
    </script>
    <!-- Footer -->
    <footer class="bg-white/50 dark:bg-slate-900/50 backdrop-blur-lg border-t border-white/50 dark:border-slate-800 mt-auto">
        <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row justify-between items-center gap-2 text-center">
            <p class="text-xs text-slate-400">
                © {{ date('Y') }}
                <a href="https://solokkota.go.id/" target="_blank" rel="noopener" class="hover:text-primary transition-colors font-medium">Pemerintah Kota Solok</a>
                · Dikelola oleh
                <a href="https://kominfo.solokkota.go.id/" target="_blank" rel="noopener" class="hover:text-primary transition-colors font-medium">Diskominfo Kota Solok</a>
            </p>
            <a href="{{ route('public.dashboard') }}" class="text-xs text-slate-400 hover:text-primary transition-colors font-medium flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">fingerprint</span>
                SIABSEN Kota Solok
            </a>
        </div>
    </footer>

</body>
</html>
