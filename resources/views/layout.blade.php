<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SILOGIS | Biro Logistik Polda NTB</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;600;700;800;900&family=Russo+One&family=Bungee&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            primary: '#0062ff',
                            light: '#f8fafc', // slate-50
                            dark: '#0f172a', // slate-900
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        ::selection { background: #0062ff; color: white; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #f59e0b; }

        .floating-nav {
            position: fixed;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 4rem);
            max-width: 1200px;
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 2rem;
            z-index: 1000;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.3);
        }

        @media (max-width: 768px) {
            .floating-nav {
                top: 1rem;
                width: calc(100% - 1.5rem);
                border-radius: 1.5rem;
            }
        }
        
        .nav-scrolled {
            top: 1rem;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(245, 158, 11, 0.15);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
        }

        .nav-link {
            position: relative;
            font-size: 11px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
        }
        .nav-link:hover { color: #f59e0b; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #f59e0b;
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        .nav-link:hover::after { width: 100%; }
        
        /* Active State */
        .nav-link.active { color: #f59e0b; }
        .nav-link.active::after { width: 100%; }

        html {
            scroll-behavior: smooth;
        }

        body {
            scroll-snap-type: y proximity;
        }

        section {
            scroll-snap-align: start;
            scroll-snap-stop: always;
            scroll-margin-top: 0;
        }


        .dot-pattern {
            background-image: radial-gradient(rgba(255,255,255,0.05) 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .shimmer-effect {
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        .mesh-gradient {
            background: radial-gradient(at 0% 0%, rgba(0, 98, 255, 0.1) 0, transparent 50%),
                        radial-gradient(at 50% 0%, rgba(255, 230, 0, 0.05) 0, transparent 50%),
                        radial-gradient(at 100% 0%, rgba(255, 0, 0, 0.05) 0, transparent 50%);
        }

        .glass-premium {
            background: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(100px) scale(0.95);
            transition: all 1s cubic-bezier(0.34, 1.56, 0.64, 1);
            filter: blur(10px);
            will-change: transform, opacity, filter;
        }
        .reveal-on-scroll.active {
            opacity: 1;
            transform: translateY(0) scale(1);
            filter: blur(0);
        }

        /* 3D Section Depth - Desktop Only */
        @media (min-width: 768px) {
            section {
                scroll-margin-top: 120px;
                transition: transform 1s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.8s ease, filter 0.8s ease;
                transform-style: preserve-3d;
                backface-visibility: hidden;
                will-change: transform, opacity, filter;
            }
            
            section[id]:not(.active-section) {
                opacity: 0.6;
                transform: scale(0.9) translateZ(-100px);
                filter: blur(3px);
            }

            section.active-section {
                opacity: 1;
                transform: scale(1) translateZ(0);
                filter: blur(0);
            }
        }

        /* Nav Link 3D Tilt */
        .nav-link {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-block;
        }
        .nav-link:hover {
            transform: translateY(-2px) scale(1.1) translateZ(20px);
            text-shadow: 0 10px 20px rgba(0, 98, 255, 0.2);
        }

        .elite-3d-red {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            background: linear-gradient(to bottom, #ef4444 0%, #7f1d1d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 4px 10px rgba(127, 29, 29, 0.2));
            letter-spacing: 0.1em;
        }

        .elite-3d-yellow {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            background: linear-gradient(to bottom, #fbbf24 0%, #92400e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 4px 10px rgba(146, 64, 14, 0.2));
            letter-spacing: 0.1em;
        }

        /* Bottom Nav Mobile */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #0f172a;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            padding: 0.5rem 0;
            z-index: 2000;
            display: flex;
            justify-content: space-around;
            align-items: flex-end;
            padding-bottom: env(safe-area-inset-bottom, 1rem);
            box-shadow: 0 -10px 40px rgba(0,0,0,0.3);
        }

        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.25rem;
            color: #64748b;
            transition: all 0.3s ease;
            width: 20%;
        }

        .bottom-nav-item.active {
            color: #fbbf24;
        }

        .bottom-nav-center-wrap {
            position: relative;
            width: 20%;
            display: flex;
            justify-content: center;
        }

        .bottom-nav-center {
            position: absolute;
            bottom: 0.5rem;
            width: 4.2rem;
            height: 4.2rem;
            background: #fbbf24;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 30px rgba(251, 191, 36, 0.4);
            border: 5px solid #0f172a;
            color: #0f172a;
            transition: all 0.3s ease;
        }

        .bottom-nav-center:active {
            transform: scale(0.9);
        }

        @media (max-width: 768px) {
            body { padding-bottom: 5rem; }
        }

        /* Floating WA Style */
        .wa-floating {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 70px;
            height: 70px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 10px 40px rgba(37, 211, 102, 0.4);
            z-index: 9999;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        @media (max-width: 768px) {
            .wa-floating {
                display: none;
            }
        }

        .wa-floating:hover {
            transform: scale(1.1) rotate(10deg);
            background: #128c7e;
            box-shadow: 0 15px 50px rgba(37, 211, 102, 0.6);
        }

        .wa-pulse {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #25d366;
            animation: pulse-wa 2s infinite;
            z-index: -1;
            opacity: 0.6;
        }

        @keyframes pulse-wa {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.6); opacity: 0; }
        }

        @keyframes elite-text-shimmer {
            0% { background-position: 100% center; }
            100% { background-position: -100% center; }
        }

        .elite-shimmer-effect {
            background: linear-gradient(
                to right, 
                #dc2626 0%, 
                #eab308 45%, 
                #ffffff 50%, 
                #eab308 55%, 
                #dc2626 100%
            );
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: elite-text-shimmer 15s infinite linear;
        }
        [x-cloak] { display: none !important; }
        
        /* 3D Page Transitions (Lovable iOS Modal Style) - Desktop Only */
        @media (min-width: 768px) {
            :root {
                --transition-speed: 0.7s;
            }

            /* The main container acts as the card */
            main {
                transition: transform var(--transition-speed) cubic-bezier(0.32, 0.72, 0, 1), 
                            opacity var(--transition-speed) cubic-bezier(0.32, 0.72, 0, 1),
                            border-radius var(--transition-speed) cubic-bezier(0.32, 0.72, 0, 1),
                            filter var(--transition-speed) cubic-bezier(0.32, 0.72, 0, 1);
                transform-origin: top center;
                opacity: 1;
                transform: translateY(0) scale(1) translateZ(0);
                will-change: transform, opacity, border-radius, filter;
                background: #0f172a;
                border-radius: 0px; 
                min-height: 100vh;
                box-shadow: 0 -20px 40px rgba(0,0,0,0.3);
            }

            /* Initial state on load (Entry - coming from bottom) */
            .page-entering main {
                /* Start from almost offscreen bottom */
                transform: translateY(100vh) scale(1);
                opacity: 1;
                border-radius: 30px 30px 0 0;
            }

            /* State when leaving (Exit - pushing back and down) */
            .page-leaving main {
                opacity: 0.5 !important;
                /* Shrink, push back, and add radius to simulate the back card */
                transform: translateY(20px) scale(0.92) translateZ(-100px) !important;
                border-radius: 30px !important;
                pointer-events: none;
                filter: blur(2px) !important;
            }

            .page-loading-overlay {
                position: fixed;
                inset: 0;
                background: #0f172a;
                z-index: -1; 
                pointer-events: none;
            }
            
            .page-entering .page-loading-overlay {
                opacity: 1;
            }

            /* Animations for Desktop Logo and Text */
            .desktop-float {
                animation: float-desktop-logo 4s ease-in-out infinite;
            }
            @keyframes float-desktop-logo {
                0%, 100% { transform: translateY(0) rotate(0deg); }
                50% { transform: translateY(-3px) rotate(3deg) scale(1.05); }
            }
            .desktop-shimmer {
                background: linear-gradient(to right, #dc2626 0%, #eab308 40%, #ffffff 50%, #eab308 60%, #dc2626 100%);
                background-size: 200% auto;
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                animation: shimmer-desktop-text 4s infinite linear;
            }
            @keyframes shimmer-desktop-text {
                0% { background-position: 200% center; }
                100% { background-position: -200% center; }
            }
        }

        body {
            overflow-x: hidden;
            background: #0f172a;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ activeSection: 'beranda', isAutoScrolling: false }" @scroll-spy.window="if(!isAutoScrolling) activeSection = $event.detail" class="antialiased text-white selection:bg-amber-500/10 selection:text-amber-500 page-entering">
    <div class="page-loading-overlay"></div>
    @php
        $waNumber = $profile?->whatsapp ?? '6281234567890';
        $waNumber = preg_replace('/[^0-9]/', '', $waNumber);
        $waNumber = preg_replace('/^0/', '62', $waNumber);
    @endphp
    <!-- Floating Island Navigation -->
    <nav id="main-nav" class="floating-nav hidden lg:block" x-data="{ mobileMenu: false }">
        <div class="px-6 md:px-8 flex justify-between h-20 items-center">
            <a href="#" @click.prevent="activeSection = 'beranda'" class="flex items-center gap-3 md:gap-4 group">
                <img src="{{ isset($profile) && $profile->logo ? asset('storage/' . $profile->logo) : (\App\Models\Profile::first()?->logo ? asset('storage/' . \App\Models\Profile::first()->logo) : asset('log polri.png')) }}" class="h-8 md:h-10 w-auto desktop-float" alt="SILOGIS Logo">
                <div class="flex flex-col">
                    <span class="text-lg md:text-2xl font-black italic leading-none font-outfit uppercase tracking-[0.2em] bg-gradient-to-r from-red-500 via-yellow-500 to-white bg-clip-text text-transparent desktop-shimmer">SILOGIS</span>
                    <span class="text-[7px] md:text-[8px] font-black text-slate-400 uppercase tracking-[0.1em] mt-1">Sistem Informasi Logistik</span>
                </div>
            </a>
            
            <!-- Desktop Links -->
            <div class="hidden lg:flex items-center gap-10">
                <div class="flex items-center gap-8">
                    @php 
                        $links = [
                            'Beranda' => 'beranda', 
                            'Berita' => 'berita', 
                            'Dokumen' => 'dokumen', 
                            'Bagian/Fungsi' => 'bagian',
                            'Struktur' => 'struktur'
                        ]; 
                    @endphp
                    @foreach($links as $name => $id)
                        <a href="{{ route('portal.index') }}#{{ $id }}" 
                           @click="activeSection = '{{ $id }}'; isAutoScrolling = true; setTimeout(() => { isAutoScrolling = false; history.replaceState(null, null, window.location.pathname); }, 1000)" 
                           :class="{ 'active': activeSection === '{{ $id }}' }"
                           class="nav-link">{{ $name }}</a>
                    @endforeach
                </div>
                
                <div class="h-6 w-px bg-white/10"></div>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="bg-brand-primary text-white hover:bg-brand-dark hover:text-white px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all shadow-lg shadow-brand-primary/20 italic">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-[#800000] text-white hover:bg-red-900 px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all italic shadow-lg shadow-red-900/20">Login Access</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <nav class="lg:hidden bottom-nav">
        <a href="{{ route('portal.index') }}#beranda" @click="activeSection = 'beranda'; isAutoScrolling = true; setTimeout(() => { isAutoScrolling = false; history.replaceState(null, null, window.location.pathname); }, 1000)" 
           class="bottom-nav-item" :class="activeSection === 'beranda' ? 'active' : ''">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            <span class="text-[9px] font-bold uppercase tracking-tighter">Beranda</span>
        </a>
        <a href="{{ route('portal.index') }}#berita" @click="activeSection = 'berita'; isAutoScrolling = true; setTimeout(() => { isAutoScrolling = false; history.replaceState(null, null, window.location.pathname); }, 1000)" 
           class="bottom-nav-item" :class="activeSection === 'berita' ? 'active' : ''">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/></svg>
            <span class="text-[9px] font-bold uppercase tracking-tighter">Berita</span>
        </a>
        <div class="bottom-nav-center-wrap" x-data="{ showContact: false }">
            <a href="#" @click.prevent="showContact = !showContact" class="bottom-nav-center">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                </svg>
            </a>

            <!-- Dropdown Contact Modal -->
            <div x-show="showContact" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                 @click.away="showContact = false" 
                 class="absolute bottom-[5.5rem] left-1/2 -translate-x-1/2 bg-slate-900 border border-white/10 rounded-2xl p-2 shadow-2xl w-48 flex flex-col gap-2 z-[9999]" style="display: none;">
                
                <div class="text-center pb-2 pt-1 border-b border-white/10">
                    <span class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Konsultasi Via</span>
                </div>

                <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text=Halo%20Admin%20Silogis..." target="_blank" class="flex items-center gap-3 px-4 py-3 bg-[#25d366]/10 hover:bg-[#25d366]/20 text-[#25d366] rounded-xl transition-all font-bold text-xs uppercase tracking-wider group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .004 5.408.001 12.045a11.815 11.815 0 001.591 5.976L0 24l6.135-1.61a11.803 11.803 0 005.911 1.586h.005c6.635 0 12.045-5.408 12.048-12.047a11.8 11.8 0 00-3.543-8.514z"/>
                    </svg>
                    WhatsApp
                </a>

                <a href="{{ $profile?->instagram ?? 'https://instagram.com' }}" target="_blank" class="flex items-center gap-3 px-4 py-3 bg-pink-500/10 hover:bg-pink-500/20 text-pink-500 rounded-xl transition-all font-bold text-xs uppercase tracking-wider group">
                    <svg class="w-5 h-5 group-hover:scale-110 transition-transform" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                    Instagram
                </a>
            </div>
        </div>
        <a href="{{ route('portal.index') }}#dokumen" @click="activeSection = 'dokumen'; isAutoScrolling = true; setTimeout(() => { isAutoScrolling = false; history.replaceState(null, null, window.location.pathname); }, 1000)" 
           class="bottom-nav-item" :class="activeSection === 'dokumen' ? 'active' : ''">
            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm-6 10H6v-2h8v2zm4-4H6v-2h12v2z"/></svg>
            <span class="text-[9px] font-bold uppercase tracking-tighter">Dokumen</span>
        </a>
        <a href="{{ route('portal.index') }}#bagian" @click="activeSection = 'bagian'; isAutoScrolling = true; setTimeout(() => { isAutoScrolling = false; history.replaceState(null, null, window.location.pathname); }, 1000)" 
           class="bottom-nav-item" :class="activeSection === 'bagian' ? 'active' : ''">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
            <span class="text-[9px] font-bold uppercase tracking-tighter">Bag</span>
        </a>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer Removed -->
    
    <!-- Floating WA Button -->
    <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text=Halo%20Admin%20Silogis,%20saya%20ingin%20konsultasi..." class="wa-floating group" title="Konsultasi via WhatsApp">
        <div class="wa-pulse"></div>
        <svg class="w-10 h-10 transition-transform group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .004 5.408.001 12.045a11.815 11.815 0 001.591 5.976L0 24l6.135-1.61a11.803 11.803 0 005.911 1.586h.005c6.635 0 12.045-5.408 12.048-12.047a11.8 11.8 0 00-3.543-8.514z"/>
        </svg>
    </a>

    <script>
        // Force scroll to top on refresh
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        
        // Remove hash on initial load to prevent browser from auto-scrolling
        if (window.location.hash) {
            history.replaceState(null, null, window.location.pathname);
        }

        // Ensure we scroll to top AFTER the page finishes rendering
        window.addEventListener('load', () => {
            setTimeout(() => {
                window.scrollTo(0, 0);
                window.dispatchEvent(new CustomEvent('scroll-spy', { detail: 'beranda' }));
            }, 50);
        });

        // Scroll Management
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('main-nav');
            if (window.scrollY > 100) {
                nav.classList.add('nav-scrolled');
            } else {
                nav.classList.remove('nav-scrolled');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Remove entering class to trigger entry animation
            setTimeout(() => {
                document.body.classList.remove('page-entering');
            }, 100);

            // Handle Page Exit
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    const target = this.getAttribute('target');
                    
                    if (!href || href.startsWith('#') || href === '#' || target === '_blank' || e.metaKey || e.ctrlKey) return;

                    try {
                        const url = new URL(href, window.location.href);
                        
                        // If same page (different hash or same), don't trigger exit animation
                        if (url.origin === window.location.origin && url.pathname === window.location.pathname) {
                            return;
                        }

                        // Filter social and common non-page links
                        if (href.includes('whatsapp.com') || href.startsWith('tel:') || href.startsWith('mailto:')) return;

                        e.preventDefault();
                        document.body.classList.add('page-leaving');
                        
                        setTimeout(() => {
                            window.location.href = href;
                        }, 500);
                    } catch (err) {
                        // Fallback for invalid URLs
                    }
                });
            });

            // Intersection Observer for Scroll Spy & Reveal
            const observerOptions = { 
                threshold: [0, 0.1, 0.25, 0.5, 0.75, 1.0],
                rootMargin: '-10% 0px -10% 0px' 
            };

            const ratios = {};
            const observer = new IntersectionObserver((entries) => {
                let checkScrollSpy = false;

                entries.forEach(entry => {
                    // Reveal animation
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }

                    // Track intersection ratio for scroll spy
                    if (entry.target.tagName === 'SECTION' && entry.target.id) {
                        ratios[entry.target.id] = entry.intersectionRatio;
                        checkScrollSpy = true;
                    }
                });

                if (checkScrollSpy) {
                    let maxRatio = 0;
                    let activeId = null;
                    const menuIds = ['beranda', 'layanan', 'berita', 'dokumen', 'struktur', 'bagian', 'tentang'];
                    
                    for (const id of menuIds) {
                        if ((ratios[id] || 0) > maxRatio) {
                            maxRatio = ratios[id];
                            activeId = id;
                        }
                    }

                    if (activeId && maxRatio > 0) {
                        window.dispatchEvent(new CustomEvent('scroll-spy', { detail: activeId }));
                        
                        // Add active-section class to the current section
                        document.querySelectorAll('section').forEach(sec => {
                            if (sec.id === activeId) {
                                sec.classList.add('active-section');
                            } else {
                                sec.classList.remove('active-section');
                            }
                        });
                    }
                }
            }, observerOptions);

        // Observe sections and reveal elements
        document.querySelectorAll('section[id], .reveal-on-scroll').forEach(el => observer.observe(el));
    });
</script>

@stack('modals')

</body>
</html>
