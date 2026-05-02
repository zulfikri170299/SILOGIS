<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0f172a]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | SILOGIS</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: { 800: '#1e293b', 900: '#0f172a' }
                    },
                    fontFamily: { 
                        sans: ['Inter', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif']
                    }
                }
            }
        }
    </script>
    <style>
        .mesh-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .glass-panel {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-white bg-[#0f172a] mesh-pattern relative overflow-x-hidden">
    <!-- Animated background gradients -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full bg-amber-500/10 blur-[100px]"></div>
        <div class="absolute top-[40%] -right-[10%] w-[40%] h-[60%] rounded-full bg-red-600/10 blur-[100px]"></div>
    </div>

    <div class="flex min-h-full">
        <!-- Left Side: Login Form -->
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 z-10">
            <div class="mx-auto w-full max-w-sm lg:w-[420px] glass-panel p-8 sm:p-10 rounded-3xl shadow-2xl relative">
                <!-- Decorative top line -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-1/3 h-1 bg-gradient-to-r from-transparent via-amber-500 to-transparent opacity-50"></div>
                
                <div class="text-center mb-10">
                    <img src="{{ asset('log polri.png') }}" alt="Logo Polri" class="w-24 h-24 mx-auto mb-6 drop-shadow-[0_0_15px_rgba(251,191,36,0.3)] hover:scale-105 transition-transform duration-500">
                    <h2 class="text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-200 to-slate-400 uppercase font-outfit tracking-wider">SILOGIS</h2>
                    <p class="mt-2 text-[10px] font-black tracking-[0.3em] text-amber-500 uppercase">Sistem Informasi Logistik</p>
                </div>

                <div>
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block text-[10px] font-bold tracking-widest uppercase text-slate-400 ml-1">Alamat Email</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                    class="block w-full rounded-2xl border-0 py-3.5 px-4 bg-slate-900/60 text-white shadow-inner ring-1 ring-inset ring-white/10 placeholder:text-slate-600 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm transition-all focus:bg-slate-900">
                                @error('email') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between ml-1">
                                <label for="password" class="block text-[10px] font-bold tracking-widest uppercase text-slate-400">Kata Sandi</label>
                            </div>
                            <div class="mt-2 relative" x-data="{ showPassword: false }">
                                <input id="password" name="password" x-bind:type="showPassword ? 'text' : 'password'" autocomplete="current-password" required
                                    class="block w-full rounded-2xl border-0 py-3.5 px-4 pr-12 bg-slate-900/60 text-white shadow-inner ring-1 ring-inset ring-white/10 placeholder:text-slate-600 focus:ring-2 focus:ring-inset focus:ring-amber-500 sm:text-sm transition-all focus:bg-slate-900">
                                
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-amber-500 focus:outline-none transition-colors">
                                    <!-- Eye Icon (Closed) -->
                                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <!-- Eye Icon (Open / Crossed) -->
                                    <svg x-show="showPassword" style="display: none;" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            @error('password') <p class="mt-2 text-sm text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-4 pt-4">
                            <button type="submit" class="flex w-full justify-center items-center rounded-2xl bg-gradient-to-r from-amber-600 to-amber-400 px-4 py-4 text-sm font-black uppercase tracking-widest text-[#0f172a] shadow-[0_0_20px_rgba(245,158,11,0.3)] hover:from-amber-500 hover:to-amber-300 hover:scale-[1.02] focus:outline-none transition-all active:scale-[0.98]">
                                Masuk Sistem
                            </button>
                            <a href="{{ route('portal.index') }}" class="flex w-full justify-center items-center rounded-2xl bg-white/5 border border-white/10 px-4 py-4 text-sm font-bold uppercase tracking-widest text-white shadow-sm hover:bg-white/10 focus:outline-none transition-all active:scale-[0.98]">
                                Batal / Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-12 text-center">
                <p class="text-[9px] uppercase tracking-[0.2em] font-bold text-slate-500">&copy; {{ date('Y') }} Biro Logistik Polda NTB</p>
            </div>
        </div>

        <!-- Right Side: Decorative Dashboard Image/Pattern -->
        <div class="relative hidden w-0 flex-1 lg:block bg-slate-900 overflow-hidden">
            <div class="absolute inset-0 h-full w-full">
                <!-- Using a dark modern gradient for now -->
                <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-[#0f172a] mix-blend-multiply opacity-90"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_2px_2px,rgba(255,255,255,0.03)_1px,transparent_0)] [background-size:24px_24px]"></div>
                
                <div class="flex h-full flex-col justify-center px-24 text-white relative z-10">
                    <div class="w-20 h-2 bg-gradient-to-r from-amber-500 to-amber-300 rounded-full mb-10 shadow-[0_0_15px_rgba(245,158,11,0.5)]"></div>
                    <h1 class="text-6xl lg:text-7xl font-black leading-none tracking-tighter font-outfit uppercase mb-4">
                        KENDALI PUSAT<br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-500 to-amber-200">OPERASIONAL</span>
                    </h1>
                    <p class="mt-6 text-xl text-slate-400 max-w-xl leading-relaxed font-medium">
                        Akses sistem eksklusif untuk mengelola logistik, inventaris digital, dan informasi struktural di lingkungan Biro Logistik Polda NTB.
                    </p>
                    <div class="mt-16 flex space-x-16 border-t border-white/10 pt-10">
                        <div class="flex flex-col">
                            <span class="text-5xl font-black font-outfit text-white drop-shadow-lg">100%</span>
                            <span class="text-[11px] uppercase tracking-[0.3em] text-amber-500 mt-3 font-black">Terkontrol</span>
                        </div>
                        <div class="w-px h-20 bg-white/10"></div>
                        <div class="flex flex-col">
                            <span class="text-5xl font-black font-outfit text-white drop-shadow-lg">Aman</span>
                            <span class="text-[11px] uppercase tracking-[0.3em] text-amber-500 mt-3 font-black">Otentikasi Terenkripsi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
