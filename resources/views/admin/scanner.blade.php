<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Scanner Attendance - Siabsen</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/siabsenlogotrs.png') }}" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <meta name="theme-color" content="#0F4C75"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/html5-qrcode"></script>
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
                },
            },
        }
    </script>
    <style>
        @keyframes scan-animation {
            0% { top: 0%; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        .scan-line {
            position: absolute;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, transparent, #3282B8, transparent);
            animation: scan-animation 2s ease-in-out infinite;
            z-index: 10;
        }
        #reader {
            border: none !important;
            border-radius: 1.5rem !important;
            overflow: hidden !important;
            width: 100% !important;
            height: 100% !important;
        }
        #reader video {
            object-fit: cover !important;
            border-radius: 1.5rem !important;
            width: 100% !important;
            height: 100% !important;
        }
        /* Hide html5-qrcode default UI elements */
        #reader__scan_region {
            border: none !important;
        }
        #reader__dashboard {
            display: none !important;
        }
        /* Important: hide the secondary internal box from the library */
        #reader img[alt="Info icon"], 
        #reader img[alt="Camera icon"] {
            display: none !important;
        }
        /* This hides the default library scanning box */
        div[id^="reader__scan_region"] > div {
            display: none !important;
        }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 font-display min-h-screen flex flex-col">
    
    <!-- Top Nav -->
    <header class="bg-white/60 dark:bg-slate-900/60 backdrop-blur-xl border-b border-white/50 dark:border-slate-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl text-slate-500 transition-colors">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="text-xl font-black text-slate-800 tracking-tight">Scanner Kehadiran</h1>
            </div>
            
            <div id="connection-status" class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider">
                <span class="size-2 bg-emerald-500 rounded-full animate-pulse"></span>
                System Online
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto w-full p-4 sm:p-6 grid grid-cols-1 lg:grid-cols-12 gap-8 py-8">
        
        <!-- Left: Scanner View (7 cols) -->
        <div class="lg:col-span-7 flex flex-col gap-6">
            <div class="relative group">
                <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-[2.5rem] translate-y-3 translate-x-3 transition-transform md:group-hover:translate-y-4 md:group-hover:translate-x-4"></div>
                <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl rounded-[2.5rem] p-6 sm:p-10 border border-white dark:border-slate-700 shadow-2xl shadow-primary-dark/10 flex flex-col items-center transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                    
                    <!-- Decorative Elements -->
                    <div class="absolute -top-24 -right-24 size-64 bg-primary-light/10 blur-[80px] rounded-full"></div>
                    
                    <div class="w-full max-w-[500px] relative z-10 flex flex-col items-center">
                        <div class="w-full aspect-square relative rounded-[2rem] overflow-hidden bg-slate-50 dark:bg-slate-900 border-4 border-white dark:border-slate-800 shadow-inner group/scan">
                            <!-- Custom Scan Overlay (UI ONLY) -->
                            <div id="scan-overlay" class="absolute inset-0 pointer-events-none z-20 flex items-center justify-center">
                                <div class="size-64 sm:size-80 border-2 border-primary-100/40 rounded-[2rem] relative">
                                    <div class="absolute -top-1 -left-1 size-8 border-t-4 border-l-4 border-primary rounded-tl-2xl transition-all group-hover/scan:scale-110"></div>
                                    <div class="absolute -top-1 -right-1 size-8 border-t-4 border-r-4 border-primary rounded-tr-2xl transition-all group-hover/scan:scale-110"></div>
                                    <div class="absolute -bottom-1 -left-1 size-8 border-b-4 border-l-4 border-primary rounded-bl-2xl transition-all group-hover/scan:scale-110"></div>
                                    <div class="absolute -bottom-1 -right-1 size-8 border-b-4 border-r-4 border-primary rounded-br-2xl transition-all group-hover/scan:scale-110"></div>
                                    
                                    <div class="scan-line"></div>
                                </div>
                            </div>
                            
                            <!-- The Reader -->
                            <div id="reader" class="rounded-[2rem] w-full h-full"></div>
                        </div>

                        <div class="mt-10 flex flex-col items-center gap-2 text-center w-full">
                            <p class="text-xs font-bold text-primary uppercase tracking-widest bg-primary-100 px-3 py-1 rounded-full">Siap Memindai</p>
                            <h2 class="text-2xl sm:text-3xl font-black text-slate-800 dark:text-white tracking-tight mt-1">Arahkan Kode QR ke Kamera</h2>
                        </div>

                        <!-- Action Controls -->
                        <div class="mt-8 flex justify-center w-full">
                            <button id="btn-toggle-camera" class="px-6 py-3 bg-slate-800 hover:bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-bold text-sm flex items-center gap-2 shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all w-full max-w-xs justify-center">
                                <span class="material-symbols-outlined text-[20px]">flip_camera_ios</span>
                                <span>Ganti Kamera (Putar)</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Last Result Card (Floating Alert Style) -->
            <div id="scan-result" class="hidden transform transition-all duration-300 translate-y-4 opacity-0">
                <div class="bg-primary rounded-2xl p-6 text-white shadow-2xl flex items-center justify-between border-4 border-white/20">
                    <div class="flex items-center gap-4">
                        <div class="size-12 bg-white/20 rounded-xl flex items-center justify-center">
                            <span class="material-symbols-outlined text-[32px]">check_circle</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-lg" id="result-name">Budi Sudarsono</h4>
                            <p class="text-primary-100 text-sm" id="result-status">Scan IN Berhasil • 08:30 WIB</p>
                        </div>
                    </div>
                    <div class="size-16 rounded-full border-4 border-white/30 overflow-hidden bg-white/10" id="result-avatar">
                        <!-- Initial or Image -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Log Sidebar (5 cols) -->
        <div class="lg:col-span-5 flex flex-col gap-6 h-full">
            <div class="relative group h-full flex flex-col min-h-[500px]">
                <div class="absolute inset-0 bg-slate-200/60 dark:bg-slate-700/50 rounded-[2.5rem] translate-y-3 translate-x-3 transition-transform md:group-hover:translate-y-4 md:group-hover:translate-x-4"></div>
                <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl rounded-[2.5rem] border border-white dark:border-slate-700 shadow-2xl shadow-slate-900/10 flex flex-col h-full overflow-hidden transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
                    <div class="p-8 border-b border-slate-100 dark:border-slate-800">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-xl font-black text-slate-800 dark:text-white tracking-tight">Aktivitas Hari Ini</h3>
                            <span class="px-3 py-1 bg-primary-100 dark:bg-slate-700 text-primary dark:text-primary-100 text-[10px] font-bold rounded-full uppercase tracking-widest">Live Updates</span>
                        </div>
                        <p class="text-sm text-slate-500">Log kehadiran yang tercatat hari ini melalui scanner admin.</p>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-4" id="log-list">
                        <!-- Sample Log Item -->
                        <div class="p-12 text-center text-slate-400">
                            <span class="material-symbols-outlined text-[48px] opacity-20 mb-4">history</span>
                            <p class="text-sm font-medium">Belum ada aktivitas scan</p>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-50/50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-800">
                        <button onclick="fetchScannerLogs()" class="w-full py-3.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 text-sm font-bold bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 shadow-sm transition-all hover:shadow-md flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-[18px]" id="sync-icon">sync</span>
                            Muat Ulang Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <!-- Custom Modal Result -->
    <div id="modal-result" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-sm animate-in fade-in duration-300">
        <div class="relative w-full max-w-md transform transition-all scale-95 opacity-0 duration-300" id="modal-content">
            <!-- Modal Stack Layer -->
            <div class="absolute inset-0 bg-primary-100/80 rounded-[2.5rem] translate-y-3 translate-x-3" id="modal-stack-bg"></div>
            <div class="relative bg-white/95 dark:bg-surface-dark w-full rounded-[2.5rem] border border-white shadow-2xl overflow-hidden p-8 flex flex-col items-center text-center">
                <!-- Icon Circle -->
                <div id="modal-icon-bg" class="size-24 rounded-full flex items-center justify-center mb-6 shadow-inner">
                    <span id="modal-icon" class="material-symbols-outlined text-[48px]">check_circle</span>
                </div>
                
                <h3 id="modal-title" class="text-2xl font-black mb-2 tracking-tight">Pindaian Berhasil</h3>
                <p id="modal-message" class="text-slate-500 font-medium dark:text-slate-400 leading-relaxed mb-8">Pesan akan muncul di sini.</p>
                
                <button onclick="closeResultModal()" class="w-full py-4 bg-slate-800 dark:bg-white text-white dark:text-slate-900 rounded-2xl font-bold text-lg shadow-xl hover:-translate-y-1 transition-all active:scale-95">
                    OKE, LANJUTKAN
                </button>
            </div>
        </div>
    </div>

    <!-- Success Sound (Admin discretion) -->
    <audio id="beep-sound" src="https://assets.mixkit.co/active_storage/sfx/2358/2358-preview.mp3"></audio>

    <script>
        const API_SCAN_URL = "{{ url('api/scan-qr') }}";
        const API_LIVE_URL = "{{ url('api/live-attendance') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
        
        let html5QrCode;
        let isScannerActive = false;
        let lastScannedToken = null;
        let scanningCooldown = false;

        function playBeep() {
            try {
                const audio = document.getElementById('beep-sound');
                audio.currentTime = 0;
                audio.play();
            } catch(e) {}
        }

        function createAvatar(nama) {
            const initials = nama ? nama.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2) : '??';
            return `
                <div class="w-full h-full flex items-center justify-center bg-white/20 text-white font-bold text-xl">
                    ${initials}
                </div>
            `;
        }

        function createLogItem(data, isNew = false) {
            const isIN = data.tipe === 'IN' || data.tipe_absen === 'Datang';
            const logItem = document.createElement('div');
            logItem.className = `flex flex-col gap-3 p-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm ${isNew ? 'animate-in fade-in slide-in-from-right-4 duration-500' : ''}`;
            
            // Status Badges
            let statusBadge = '';
            if (data.status_hari_ini === 'Hadir Penuh') {
                statusBadge = `<span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-50 text-green-600 dark:bg-green-900/20 border border-green-100 dark:border-green-800">HADIR PENUH</span>`;
            } else if (data.status_hari_ini === 'Hadir Setengah') {
                statusBadge = `<span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-50 text-yellow-600 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800">HADIR SETENGAH</span>`;
            } else {
                statusBadge = `<span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-50 text-red-600 dark:bg-red-900/20 border border-red-100 dark:border-red-800">ABSEN</span>`;
            }

            logItem.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="size-10 rounded-full flex items-center justify-center font-bold text-xs ${isIN ? 'bg-blue-100 text-blue-700' : 'bg-slate-100 text-slate-700'}">
                        ${data.nama.substring(0,2).toUpperCase()}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold truncate">${data.nama}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span class="text-[10px] font-bold ${isIN ? 'text-blue-500' : 'text-slate-500'} uppercase tracking-tight">${isIN ? 'MASUK' : 'PULANG'}</span>
                            <span class="text-slate-300">•</span>
                            <span class="text-[10px] font-mono font-bold text-slate-400">${data.waktu} WIB</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-slate-50 dark:border-slate-700">
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Status Hari Ini</span>
                    ${statusBadge}
                </div>
            `;
            return logItem;
        }

        async function fetchScannerLogs() {
            const list = document.getElementById('log-list');
            const syncIcon = document.getElementById('sync-icon');
            if(syncIcon) syncIcon.classList.add('animate-spin');

            try {
                const response = await fetch(API_LIVE_URL);
                const result = await response.json();
                
                if (result.status === 'success') {
                    list.innerHTML = '';
                    if (result.data.length === 0) {
                        list.innerHTML = `
                            <div class="p-12 text-center text-slate-400">
                                <span class="material-symbols-outlined text-[48px] opacity-20 mb-4">history</span>
                                <p class="text-sm">Belum ada aktivitas scan</p>
                            </div>
                        `;
                    } else {
                        result.data.forEach(item => {
                            list.appendChild(createLogItem(item));
                        });
                    }
                }
            } catch (err) {
                console.error("Fetch Logs Error:", err);
            } finally {
                if(syncIcon) setTimeout(() => syncIcon.classList.remove('animate-spin'), 600);
            }
        }

        function updateLogUI(data) {
            const list = document.getElementById('log-list');
            
            // Remove empty state if present
            if (list.querySelector('.p-12')) {
                list.innerHTML = '';
            }

            const logItem = createLogItem(data, true);
            list.prepend(logItem);

            // Show Floating Result
            const resultBox = document.getElementById('scan-result');
            const resultName = document.getElementById('result-name');
            const resultStatus = document.getElementById('result-status');
            const resultAvatar = document.getElementById('result-avatar');

            resultName.textContent = data.nama;
            resultStatus.textContent = `Scan ${data.tipe === 'IN' ? 'MASUK' : 'PULANG'} Berhasil • ${data.waktu} WIB`;
            resultAvatar.innerHTML = createAvatar(data.nama);

            resultBox.classList.remove('hidden');
            setTimeout(() => {
                resultBox.classList.add('translate-y-0', 'opacity-100');
                resultBox.classList.remove('translate-y-4');
            }, 10);

            // Hide after 5 sec
            setTimeout(() => {
                resultBox.classList.add('translate-y-4', 'opacity-0');
                resultBox.classList.remove('translate-y-0');
                setTimeout(() => resultBox.classList.add('hidden'), 300);
            }, 5000);
        }

        function showResultModal(status, title, message) {
            const modal = document.getElementById('modal-result');
            const content = document.getElementById('modal-content');
            const iconBg = document.getElementById('modal-icon-bg');
            const icon = document.getElementById('modal-icon');
            const titleEl = document.getElementById('modal-title');
            const messageEl = document.getElementById('modal-message');

            // Reset classes
            iconBg.className = "size-20 rounded-full flex items-center justify-center mb-6 ";
            
            if (status === 'success') {
                iconBg.classList.add('bg-green-100', 'dark:bg-green-900/30', 'text-green-600');
                icon.textContent = 'check_circle';
                titleEl.className = "text-2xl font-bold mb-2 text-green-600";
            } else if (status === 'warning') {
                iconBg.classList.add('bg-orange-100', 'dark:bg-orange-900/30', 'text-orange-600');
                icon.textContent = 'warning';
                titleEl.className = "text-2xl font-bold mb-2 text-orange-600";
            } else {
                iconBg.classList.add('bg-red-100', 'dark:bg-red-900/30', 'text-red-600');
                icon.textContent = 'error';
                titleEl.className = "text-2xl font-bold mb-2 text-red-600";
            }

            titleEl.textContent = title;
            messageEl.textContent = message;

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeResultModal() {
            const modal = document.getElementById('modal-result');
            const content = document.getElementById('modal-content');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        async function onScanSuccess(decodedText, decodedResult) {
            if (scanningCooldown) return;
            
            if (decodedText === lastScannedToken) return;

            playBeep();
            scanningCooldown = true;
            lastScannedToken = decodedText;

            try {
                const response = await fetch(API_SCAN_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    body: JSON.stringify({ qr_code_token: decodedText })
                });

                const data = await response.json();

                if (response.ok && data.status === 'success') {
                    updateLogUI(data.data);
                    showResultModal('success', 'Pindaian Berhasil', data.message);
                } else if (data.status === 'warning') {
                    showResultModal('warning', 'Tunggu Sebentar', data.message);
                } else {
                    showResultModal('error', 'Gagal', data.message || 'QR Code tidak valid atau terjadi kesalahan.');
                }
            } catch (err) {
                console.error(err);
                showResultModal('error', 'Koneksi Bermasalah', "Gagal terhubung ke server saat memproses scan.");
            } finally {
                setTimeout(() => {
                    scanningCooldown = false;
                    lastScannedToken = null;
                }, 3000); // 3 sec internal cooldown
            }
        }

        async function startScanner() {
            // Diagnostik Sederhana
            if (!window.isSecureContext) {
                showResultModal('error', 'Masalah Keamanan', "Browser mendeteksi koneksi ini tidak aman. Kamera hanya bisa dibuka lewat HTTPS/Localhost.");
                return;
            }

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                showResultModal('error', 'Tidak Didukung', "Browser Anda tidak mendukung akses kamera atau fitur ini diblokir.");
                return;
            }

            try {
                const devices = await Html5Qrcode.getCameras();
                if (!devices || devices.length === 0) {
                    showResultModal('error', 'Kamera Hilang', "Kamera tidak ditemukan pada perangkat ini. Pastikan Anda telah mengizinkan akses ke periferal kamera browser lalu muat ulang (refresh) halaman.");
                    return;
                }

                html5QrCode = new Html5Qrcode("reader");
                const config = { 
                    fps: 20, 
                    aspectRatio: 1.0,
                    videoConstraints: {
                        facingMode: "environment",
                        aspectRatio: { ideal: 1.0 }
                    }
                };

                await html5QrCode.start(
                    { facingMode: "environment" }, 
                    config, 
                    onScanSuccess
                );
            } catch (err) {
                console.error("Camera Error:", err);
                showResultModal('error', 'Kamera Error', "Gagal mengakses kamera. Muat ulang (refresh) halaman lalu pastikan ijin kamera browser telah diberikan dan Anda tidak membukanya bersamaan dengan aplikasi lain.");
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            fetchScannerLogs(); // Initial Load
            startScanner(); // Initiate scanning instantly
            
            document.getElementById('btn-toggle-camera').addEventListener('click', () => {
                if (html5QrCode) {
                    html5QrCode.stop().then(() => startScanner());
                }
            });
        });
    </script>
</body>
</html>
