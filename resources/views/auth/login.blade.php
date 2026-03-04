<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login Admin - Siabsen Kota Solok</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/siabsenlogotrs.png') }}" />
    <meta name="theme-color" content="#0F4C75"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
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
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="relative group w-full max-w-md">
        <div class="absolute inset-0 bg-primary-100/60 rounded-[2rem] translate-y-3 translate-x-3 transition-transform md:group-hover:translate-y-4 md:group-hover:translate-x-4"></div>
        
        <div class="relative bg-white/95 backdrop-blur-xl rounded-[2rem] shadow-2xl shadow-primary-dark/10 overflow-hidden border border-white flex flex-col transition-transform md:group-hover:-translate-y-1 md:group-hover:-translate-x-1">
            
            <div class="bg-primary px-6 py-8 text-center relative overflow-hidden rounded-t-[2rem]">
                <button onclick="toggleTheme()" class="absolute top-4 right-4 z-20 p-2 text-white/70 hover:text-white transition-colors rounded-xl bg-black/10 hover:bg-black/20" title="Toggle Theme">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                </button>
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-primary-light/50 rounded-full blur-xl"></div>
                
                <div class="relative z-10">
                    <div class="h-20 w-20 bg-white/20 backdrop-blur-md rounded-2xl mx-auto p-2 mb-4 flex items-center justify-center border border-white/30 shadow-lg">
                        <img src="{{ asset('assets/images/siabsenlogotrs.png') }}" alt="Logo" class="w-full h-full object-contain filter drop-shadow-sm">
                    </div>
                    <h1 class="text-2xl font-black text-white tracking-tight">Portal Admin</h1>
                    <p class="text-primary-100 text-sm mt-1 font-medium">Sistem Informasi Absensi Kota Solok</p>
                </div>
            </div>

            <div class="p-8 pb-4">
                <div class="mb-8 flex items-center justify-center gap-2 text-primary font-bold bg-primary-100 py-2 px-4 rounded-xl mx-auto w-max">
                    <span class="material-symbols-outlined text-[20px]">shield_person</span>
                    <span>Login Admin</span>
                </div>

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 border border-red-100 text-sm flex gap-2">
                    <span class="material-symbols-outlined text-[18px]">error</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-1">Username <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px] pointer-events-none">person</span>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary focus:bg-white transition-all placeholder:text-slate-400" 
                            placeholder="Ketik username admin">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">Kata Sandi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-[20px] pointer-events-none">key</span>
                        <input type="password" id="password" name="password" required 
                            class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-primary/40 focus:border-primary focus:bg-white transition-all placeholder:text-slate-400" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-4 mb-2">
                    <button type="submit" class="w-full py-3 px-4 bg-primary md:hover:bg-primary-light text-white font-bold rounded-xl shadow-lg shadow-primary/30 transition-all md:hover:shadow-primary/50 md:hover:-translate-y-0.5 flex justify-center items-center gap-2">
                        <span>Login</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                    
                    <a href="{{ route('public.dashboard') }}" class="w-full mt-4 py-3 px-4 bg-white hover:bg-slate-50 text-slate-600 font-bold rounded-xl border border-slate-200 transition-all flex justify-center items-center gap-2 group">
                        <span class="material-symbols-outlined text-[18px] text-slate-400 group-hover:text-slate-600">arrow_back</span>
                        <span>Dashboard Publik</span>
                    </a>
                </div>
            </form>
        </div>
        
        <div class="py-5 bg-slate-50 border-t border-slate-100 text-center rounded-b-[2rem] px-4">
            <p class="text-xs text-slate-400">
                © {{ date('Y') }}
                <a href="https://solokkota.go.id/" target="_blank" rel="noopener" class="hover:text-primary transition-colors font-medium">Pemerintah Kota Solok</a>
            </p>
            <p class="text-xs text-slate-400 mt-1">
                Dikelola oleh
                <a href="https://kominfo.solokkota.go.id/" target="_blank" rel="noopener" class="hover:text-primary transition-colors font-medium">Diskominfo Kota Solok</a>
                ·
                <a href="{{ route('public.dashboard') }}" class="hover:text-primary transition-colors font-medium">SIABSEN Kota Solok</a>
            </p>
        </div>
        
    </div>

</body>
</html>
