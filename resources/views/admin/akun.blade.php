<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Manajemen Akun - SIABSEN Kota Solok</title>
    <meta name="theme-color" content="#0F4C75"/>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/siabsenlogotrs.png') }}" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
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
                        "slate": {
                            800: "rgb(var(--color-slate-800) / <alpha-value>)",
                            900: "rgb(var(--color-slate-900) / <alpha-value>)"
                        }
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"],
                        "sans": ["Inter", "sans-serif"]
                    },
                }
            }
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

    <!-- Header — sama persis dengan admin dashboard -->
    <header class="bg-white/60 dark:bg-slate-900/60 backdrop-blur-xl border-b border-white/50 dark:border-slate-800 sticky top-0 z-50">
        <div class="w-full max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16 sm:h-20">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="p-2 text-slate-500 dark:text-slate-400 hover:text-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors" title="Kembali ke Dashboard">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 sm:h-12 sm:w-12 bg-blue-500/10 rounded-lg p-1 flex items-center justify-center shrink-0">
                        <img src="{{ asset('assets/images/siabsenlogo.png') }}" alt="Logo" class="w-full h-full object-contain filter drop-shadow-sm">
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-xl font-bold tracking-tight text-slate-900 dark:text-white">Manajemen Akun</h1>
                        <span class="hidden sm:inline-block text-[10px] font-bold bg-primary-100 text-primary dark:bg-primary-100/20 dark:text-primary-light px-2 py-0.5 rounded-full uppercase tracking-wider">Admin Panel</span>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Toggle Dark Mode -->
                <button onclick="toggleTheme()" class="p-2 text-slate-500 hover:text-primary dark:text-slate-400 dark:hover:text-primary-light transition-colors rounded-xl bg-slate-100 dark:bg-slate-800 flex-shrink-0" title="Toggle Tema">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                </button>
                <!-- Info Akun -->
                <span class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 rounded-full text-xs font-semibold border border-slate-200 dark:border-slate-700">
                    <span class="material-symbols-outlined text-[14px]">account_circle</span>
                    {{ Auth::user()->name }}
                </span>
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all" title="Logout">
                        <span class="material-symbols-outlined">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 w-full max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10">

        <!-- Flash Messages -->
        @if(session('success'))
        <div id="flash-success" class="flex items-start gap-3 p-4 mb-6 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-2xl text-sm font-medium transition-opacity duration-500">
            <span class="material-symbols-outlined text-[20px] shrink-0 mt-0.5">check_circle</span>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        @if(session('error'))
        <div id="flash-error" class="flex items-start gap-3 p-4 mb-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-2xl text-sm font-medium transition-opacity duration-500">
            <span class="material-symbols-outlined text-[20px] shrink-0 mt-0.5">error</span>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 items-start">

            <!-- ── FORM TAMBAH AKUN ─────────────────────────────────── -->
            <div class="lg:col-span-2">
                <div class="relative group">
                    <div class="absolute inset-0 bg-primary-100/60 dark:bg-slate-700/50 rounded-[2rem] translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                    <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-[2rem] border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 p-6 sm:p-8">
                        <div class="flex items-center gap-3 mb-7">
                            <div class="p-2.5 bg-primary-100 dark:bg-slate-700 text-primary dark:text-primary-light rounded-2xl">
                                <span class="material-symbols-outlined text-[22px]">person_add</span>
                            </div>
                            <div>
                                <h2 class="font-black text-lg text-slate-800 dark:text-white leading-tight">Tambah Akun</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Buat akun pengguna baru</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.akun.store') }}" class="space-y-4">
                            @csrf

                            <!-- Nama Lengkap -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-widest">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama pengguna"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900/60 border {{ $errors->has('name') ? 'border-red-400' : 'border-slate-200 dark:border-slate-700' }} rounded-xl text-sm text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                                @error('name')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Username -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-widest">Username</label>
                                <input type="text" name="username" value="{{ old('username') }}" placeholder="Username untuk login"
                                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900/60 border {{ $errors->has('username') ? 'border-red-400' : 'border-slate-200 dark:border-slate-700' }} rounded-xl text-sm text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                                @error('username')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-widest">Password</label>
                                <div class="relative">
                                    <input type="password" name="password" id="inp-pass" placeholder="Min. 6 karakter"
                                        class="w-full px-4 py-3 pr-11 bg-slate-50 dark:bg-slate-900/60 border {{ $errors->has('password') ? 'border-red-400' : 'border-slate-200 dark:border-slate-700' }} rounded-xl text-sm text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                                    <button type="button" onclick="togglePass('inp-pass','eye-1')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                        <span id="eye-1" class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                </div>
                                @error('password')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-1.5 uppercase tracking-widest">Konfirmasi Password</label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="inp-pass2" placeholder="Ulangi password"
                                        class="w-full px-4 py-3 pr-11 bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-all">
                                    <button type="button" onclick="togglePass('inp-pass2','eye-2')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                                        <span id="eye-2" class="material-symbols-outlined text-[20px]">visibility</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 mb-2 uppercase tracking-widest">Role / Jabatan</label>
                                <div class="flex gap-3">
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="role" value="admin" class="sr-only peer" {{ old('role') === 'admin' ? 'checked' : '' }}>
                                        <div class="flex items-center justify-center gap-2 px-3 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 peer-checked:border-primary peer-checked:bg-primary/5 dark:peer-checked:bg-primary/10 transition-all text-sm font-bold text-slate-400 dark:text-slate-500 peer-checked:text-primary dark:peer-checked:text-primary-light">
                                            <span class="material-symbols-outlined text-[18px]">admin_panel_settings</span> Admin
                                        </div>
                                    </label>
                                    <label class="flex-1 cursor-pointer">
                                        <input type="radio" name="role" value="pengawas" class="sr-only peer" {{ old('role', 'pengawas') === 'pengawas' ? 'checked' : '' }}>
                                        <div class="flex items-center justify-center gap-2 px-3 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 peer-checked:border-violet-500 peer-checked:bg-violet-50 dark:peer-checked:bg-violet-500/10 transition-all text-sm font-bold text-slate-400 dark:text-slate-500 peer-checked:text-violet-600 dark:peer-checked:text-violet-400">
                                            <span class="material-symbols-outlined text-[18px]">supervisor_account</span> Pengawas
                                        </div>
                                    </label>
                                </div>
                                @error('role')<p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit" class="w-full py-3.5 bg-primary hover:bg-primary-dark dark:hover:bg-primary-light text-white font-black rounded-2xl shadow-lg shadow-primary/20 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2 mt-2">
                                <span class="material-symbols-outlined text-[20px]">person_add</span>
                                Buat Akun
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ── DAFTAR AKUN ──────────────────────────────────────── -->
            <div class="lg:col-span-3">
                <div class="relative group h-full">
                    <div class="absolute inset-0 bg-slate-200/60 dark:bg-slate-700/50 rounded-[2rem] translate-y-2 translate-x-2 transition-transform md:group-hover:translate-y-3 md:group-hover:translate-x-3"></div>
                    <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-md rounded-[2rem] border border-white dark:border-slate-700 shadow-xl shadow-primary-dark/5 overflow-hidden flex flex-col">

                        <!-- Header daftar -->
                        <div class="px-6 sm:px-8 py-5 border-b border-slate-100 dark:border-slate-800/50 flex items-center gap-3">
                            <div class="p-2.5 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300 rounded-2xl">
                                <span class="material-symbols-outlined text-[20px]">group</span>
                            </div>
                            <div>
                                <h2 class="font-black text-lg text-slate-800 dark:text-white leading-tight">Daftar Akun</h2>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $users->count() }} akun terdaftar</p>
                            </div>
                        </div>

                        <!-- List akun -->
                        <div class="divide-y divide-slate-100 dark:divide-slate-800/50 flex-1">
                            @forelse($users as $user)
                            <div class="px-6 sm:px-8 py-4 flex items-center gap-4 hover:bg-slate-50/80 dark:hover:bg-slate-900/30 transition-colors group/row">

                                <!-- Avatar Inisial -->
                                <div class="w-11 h-11 rounded-2xl flex items-center justify-center font-black text-sm shrink-0
                                    {{ $user->role === 'admin'
                                        ? 'bg-primary/10 dark:bg-primary/20 text-primary dark:text-primary-light'
                                        : 'bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400' }}">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>

                                <!-- Info Akun -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap mb-1">
                                        <p class="font-bold text-slate-800 dark:text-white text-sm truncate">{{ $user->name }}</p>
                                        @if(Auth::id() === $user->id)
                                        <span class="px-2 py-0.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-[9px] font-black rounded-full uppercase tracking-widest shrink-0">Akun Ini</span>
                                        @endif
                                    </div>
                                    <!-- Username & Password (hashed) -->
                                    <div class="flex flex-wrap gap-x-4 gap-y-0.5">
                                        <span class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]">person</span>
                                            <span class="font-mono font-semibold">{{ $user->username }}</span>
                                        </span>
                                        <span class="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[12px]">lock</span>
                                            <span class="tracking-widest">••••••••</span>
                                            <span class="text-[10px] text-slate-300 dark:text-slate-600 italic">(terenkripsi)</span>
                                        </span>
                                    </div>
                                </div>

                                <!-- Badge Role -->
                                <span class="px-3 py-1 rounded-full text-xs font-bold shrink-0
                                    {{ $user->role === 'admin'
                                        ? 'bg-primary/10 dark:bg-primary/20 text-primary dark:text-primary-light'
                                        : 'bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400' }}">
                                    {{ ucfirst($user->role) }}
                                </span>

                                <!-- Tombol Hapus -->
                                @if(Auth::id() !== $user->id)
                                <button onclick="confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="p-2 text-transparent group-hover/row:text-slate-300 dark:group-hover/row:text-slate-600 hover:!text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all shrink-0"
                                    title="Hapus akun">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                </button>
                                @else
                                <div class="w-9 shrink-0"></div>
                                @endif
                            </div>
                            @empty
                            <div class="py-16 text-center text-slate-400">
                                <span class="material-symbols-outlined text-5xl mb-3 block opacity-30">manage_accounts</span>
                                <p class="text-sm">Belum ada akun yang terdaftar</p>
                            </div>
                            @endforelse
                        </div>

                        <!-- Info Aturan -->
                        <div class="px-6 sm:px-8 py-3.5 bg-slate-50/80 dark:bg-slate-900/30 border-t border-slate-100 dark:border-slate-800/50">
                            <p class="text-xs text-slate-400 flex items-start gap-1.5">
                                <span class="material-symbols-outlined text-[14px] mt-0.5 shrink-0">info</span>
                                <span>Setiap role wajib tersedia <strong class="text-slate-500 dark:text-slate-300">minimal 1 akun aktif</strong>. Akun yang sedang digunakan tidak dapat dihapus. Password tidak dapat dilihat karena dienkripsi.</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Konfirmasi Hapus -->
    <div id="modal-hapus" class="fixed inset-0 z-[120] hidden flex-col items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-[4px]" onclick="closeDeleteModal()"></div>
        <div class="relative w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0" id="modal-hapus-content">
            <div class="absolute inset-0 bg-red-100/40 dark:bg-red-900/20 rounded-[2.5rem] translate-y-3 translate-x-3"></div>
            <div class="relative bg-white/95 dark:bg-slate-800/95 backdrop-blur-xl rounded-[2.5rem] p-8 border border-white/50 dark:border-slate-700 shadow-2xl">
                <div class="flex items-center gap-3 mb-5">
                    <div class="p-3 bg-red-50 dark:bg-red-900/30 text-red-500 rounded-2xl shrink-0">
                        <span class="material-symbols-outlined text-3xl">delete_forever</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-slate-800 dark:text-white">Hapus Akun</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-300 mb-6">
                    Yakin ingin menghapus akun <strong id="delete-name" class="text-slate-800 dark:text-white"></strong>?
                </p>
                <div class="flex gap-3">
                    <button onclick="closeDeleteModal()" class="flex-1 py-3 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-200 rounded-2xl font-bold text-sm hover:bg-slate-200 dark:hover:bg-slate-600 transition-all">Batal</button>
                    <form id="form-hapus" method="POST" class="flex-[2]">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-bold text-sm shadow-lg shadow-red-600/30 transition-all hover:-translate-y-0.5">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        function togglePass(inputId, iconId) {
            const inp  = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            inp.type   = inp.type === 'password' ? 'text' : 'password';
            icon.textContent = inp.type === 'password' ? 'visibility' : 'visibility_off';
        }

        function confirmDelete(id, name) {
            document.getElementById('delete-name').textContent = name;
            document.getElementById('form-hapus').action = `/admin/akun/${id}`;
            const modal   = document.getElementById('modal-hapus');
            const content = document.getElementById('modal-hapus-content');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeDeleteModal() {
            const content = document.getElementById('modal-hapus-content');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                const modal = document.getElementById('modal-hapus');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        // Auto-dismiss flash messages
        ['flash-success', 'flash-error'].forEach(id => {
            const el = document.getElementById(id);
            if (el) setTimeout(() => { el.style.opacity = '0'; }, 4000);
        });
    </script>
</body>
</html>
