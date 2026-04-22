<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | PortalCorp</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        indigo: { 600: '#4f46e5', 700: '#4338ca' },
                        slate: { 900: '#0f172a' }
                    },
                    fontFamily: { sans: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans antialiased text-slate-900">
    <div class="flex min-h-full">
        <!-- Left Side: Login Form -->
        <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24 bg-white shadow-2xl z-10">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div>
                    <a href="/" class="text-3xl font-black text-indigo-600 tracking-tighter">PortalCorp</a>
                    <h2 class="mt-8 text-3xl font-bold tracking-tight text-slate-900">Selamat datang kembali</h2>
                    <p class="mt-2 text-sm text-slate-500">
                        Silakan masuk ke akun administrator Anda.
                    </p>
                </div>

                <div class="mt-10">
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-semibold leading-6 text-slate-900">Alamat Email</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                    class="block w-full rounded-xl border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-all">
                                @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm font-semibold leading-6 text-slate-900">Kata Sandi</label>
                                @if (Route::has('password.request'))
                                    <div class="text-sm">
                                        <a href="{{ route('password.request') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Lupa password?</a>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                    class="block w-full rounded-xl border-0 py-2.5 text-slate-900 shadow-sm ring-1 ring-inset ring-slate-200 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 transition-all">
                                @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="remember_me" class="ml-3 block text-sm leading-6 text-slate-600">Ingat saya</label>
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-xl bg-slate-900 px-3 py-3 text-sm font-bold leading-6 text-white shadow-sm hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-all active:scale-[0.98]">
                                Masuk Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-auto pt-10 text-center">
                <p class="text-xs text-slate-400">&copy; {{ date('Y') }} Portal Aplikasi & Berita - Antarmuka Premium</p>
            </div>
        </div>

        <!-- Right Side: Decorative Image/Pattern -->
        <div class="relative hidden w-0 flex-1 lg:block bg-indigo-600">
            <div class="absolute inset-0 h-full w-full object-cover overflow-hidden">
                <div class="absolute inset-0 bg-indigo-600 mix-blend-multiply opacity-90"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_2px_2px,rgba(255,255,255,0.15)_1px,transparent_0)] [background-size:24px_24px]"></div>
                
                <div class="flex h-full flex-col justify-center px-12 text-white relative z-10">
                    <h1 class="text-5xl font-black leading-tight tracking-tighter">Kelola ekosistem berita Anda dalam satu tempat.</h1>
                    <p class="mt-6 text-xl text-indigo-100 max-w-lg leading-relaxed">
                        Akses panel kontrol untuk mengelola aplikasi operasional dan menyebarkan informasi terbaru kepada seluruh tim.
                    </p>
                    <div class="mt-12 flex space-x-6">
                        <div class="flex flex-col">
                            <span class="text-4xl font-bold">100%</span>
                            <span class="text-xs uppercase tracking-widest text-indigo-200 mt-1 font-semibold">Terkonsolidasi</span>
                        </div>
                        <div class="w-px h-12 bg-indigo-400 opacity-30"></div>
                        <div class="flex flex-col">
                            <span class="text-4xl font-bold">Secure</span>
                            <span class="text-xs uppercase tracking-widest text-indigo-200 mt-1 font-semibold">Auth Protection</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
