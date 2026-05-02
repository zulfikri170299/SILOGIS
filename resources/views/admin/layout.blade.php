<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel | PortalCorp</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-primary': '#0062ff',
                        'brand-dark': '#0a0a0b',
                        'slate': { 
                            900: '#0f172a', 
                            950: '#020617' 
                        }
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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full font-sans antialiased text-slate-200 overflow-hidden bg-slate-950" x-data="{ sidebarOpen: false }">
    <div class="flex h-full min-h-full">
        <!-- Sidebar for Mobile (Overlay) -->
        <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-40 lg:hidden" role="dialog" aria-modal="true">
            <div x-show="sidebarOpen" 
                x-transition:enter="transition-opacity ease-linear duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition-opacity ease-linear duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm" @click="sidebarOpen = false"></div>
            
            <div x-show="sidebarOpen" 
                x-transition:enter="transition ease-in-out duration-300 transform"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in-out duration-300 transform"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="relative flex w-full max-w-[240px] flex-1 flex-col bg-slate-900 pb-4 pt-5">
                
                <div class="flex items-center justify-between px-4">
                    <span class="text-xl font-black text-white">AdminPortal</span>
                    <button type="button" class="text-slate-400 hover:text-white" @click="sidebarOpen = false">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <nav class="mt-8 flex-1 px-4 space-y-1 overflow-y-auto">
                    @include('admin.sidebar-links')
                </nav>
            </div>
        </div>

        <!-- Static Sidebar for Desktop -->
        <div class="hidden lg:flex lg:w-72 lg:flex-col lg:bg-slate-900 border-r border-white/5">
            <div class="flex h-20 shrink-0 items-center px-8 border-b border-white/5">
                <div class="flex flex-col">
                    <span class="text-xl font-black italic font-outfit uppercase tracking-[0.2em] bg-gradient-to-r from-red-600 via-yellow-500 to-black bg-clip-text text-transparent">SILOGIS</span>
                    <span class="text-[7px] font-black text-slate-400 uppercase tracking-[0.1em] mt-1">Sistem Informasi Logistik</span>
                </div>
            </div>
            <nav class="mt-8 flex-1 px-4 space-y-1.5 overflow-y-auto">
                @include('admin.sidebar-links')
            </nav>
            <div class="p-6 mt-auto border-t border-slate-800 bg-slate-900/50">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-bold text-white leading-none mb-1">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center p-2 rounded-lg text-sm font-semibold text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                        <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Keluar Sesi
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="flex flex-1 flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="flex h-14 shrink-0 items-center gap-x-4 border-b border-white/5 bg-slate-900 px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-slate-400 lg:hidden" @click="sidebarOpen = true">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
                
                <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6 items-center">
                    <div class="flex flex-1 items-center">
                         <h1 class="text-xs font-black text-white uppercase tracking-widest font-outfit">@yield('title', 'Admin Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <a href="/" target="_blank" class="text-[10px] font-black uppercase tracking-widest text-brand-primary hover:text-white transition-all flex items-center gap-2 italic">
                             Pratinjau Situs &rarr;
                        </a>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-slate-950 p-6 lg:p-12 scroll-smooth">
                 @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
