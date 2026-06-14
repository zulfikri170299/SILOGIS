@extends('layout')

@section('content')
<div x-data="{ 
    showAllServices: false, 
    showAllDocs: false, 
    searchService: '', 
    searchDoc: '',
    lockScroll(val) {
        if (val) document.body.classList.add('overflow-hidden');
        else document.body.classList.remove('overflow-hidden');
    }
}" x-init="$watch('showAllServices', v => lockScroll(v)); $watch('showAllDocs', v => lockScroll(v));"
   class="bg-[#0f172a] md:bg-transparent relative">
    <!-- Seamless Mobile Background Overlay -->
    <div class="md:hidden fixed inset-0 z-0 bg-elite-mobile pointer-events-none"></div>
    <div class="md:hidden fixed inset-0 z-0 opacity-10 pointer-events-none mesh-pattern"></div>

<!-- Custom Modern CSS -->
<style>
    .font-outfit { font-family: 'Outfit', sans-serif; }
    
    .elite-hero {
        position: relative;
        background: url('{{ asset('LB.png') }}') no-repeat center center;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 60px;
    }

    @media (max-width: 768px) {
        .elite-hero {
            min-height: 45vh;
            padding-top: 0;
        }
    }

    .elite-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.9));
    }

    @media (max-width: 768px) {
        .elite-hero::after {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2) 0%, rgba(0, 0, 0, 0.8) 70%, rgba(0, 0, 0, 1) 100%);
        }
    }

    .service-tile {
        background: rgba(30, 41, 59, 0.4);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 1.5rem;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: row;
        align-items: center;
        text-align: left;
        gap: 1.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        min-height: 120px;
    }

    .service-tile:hover {
        background: #dc2626;
        transform: translateY(-10px);
        box-shadow: 0 40px 80px -15px rgba(220, 38, 38, 0.4);
        border-color: #dc2626;
    }

    .service-tile:hover h4, .service-tile:hover p, .service-tile:hover svg {
        color: white !important;
    }

    .tile-icon {
        width: 70px; height: 70px;
        flex-shrink: 0;
        background: rgba(15, 23, 42, 0.6);
        border-radius: 1.25rem;
        display: flex; align-items: center; justify-content: center;
        padding: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .news-card-elite {
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 1.5rem;
        transition: all 0.4s ease;
        overflow: hidden;
    }

    .news-card-elite:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.5);
    }

    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    .news-card-elite {
        background: #1e293b;
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 1.5rem;
        transition: all 0.4s ease;
        overflow: hidden;
    }

    .news-card-elite:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.5);
    }

    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    .glass-card {
        background: rgba(255, 255, 255, 0.03);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 2rem;
    }

    /* Mobile Custom Animations */
    @keyframes pulseSoft {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.08); }
    }
    
    @keyframes floatSoft {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
    }

    .animate-pulse-soft {
        animation: pulseSoft 3s ease-in-out infinite;
    }
    
    .animate-float-soft {
        animation: floatSoft 4s ease-in-out infinite;
    }

    /* Active tap states for mobile */
    .tap-effect {
        transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .tap-effect:active {
        transform: scale(0.92);
    }

    /* Premium Mobile Background Overrides */
    @media (max-width: 768px) {
        .bg-elite-mobile {
            background: linear-gradient(-45deg, #0f172a, #020617, #1a0b02, #0f172a);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }
        .mesh-pattern {
            background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 30px 30px;
        }
        section {
            background-color: transparent !important;
            position: relative;
            z-index: 1;
        }
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Elite Icon Interactive States */
    .elite-icon-container {
        position: relative;
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    }
    
    .elite-icon-container::before {
        content: '';
        position: absolute;
        inset: -4px;
        background: linear-gradient(45deg, #fbbf24, #ef4444, #fbbf24);
        border-radius: inherit;
        z-index: -1;
        opacity: 0;
        transition: all 0.4s ease;
        filter: blur(12px);
    }

    .group:hover .elite-icon-container {
        transform: scale(1.12) translateY(-8px) rotate(3deg) !important;
        background: #1e293b !important;
        border-color: rgba(251, 191, 36, 0.5) !important;
        box-shadow: 0 25px 50px -12px rgba(245, 158, 11, 0.4) !important;
    }

    .group:hover .elite-icon-container::before {
        opacity: 0.6;
    }

    .group:active .elite-icon-container {
        transform: scale(0.92) !important;
        transition: all 0.2s ease !important;
    }

    /* Red version for Documents */
    .elite-icon-red::before {
        background: linear-gradient(45deg, #ef4444, #dc2626, #ef4444) !important;
    }
    
    .group:hover .elite-icon-red {
        border-color: rgba(239, 68, 68, 0.5) !important;
        box-shadow: 0 25px 50px -12px rgba(220, 38, 38, 0.4) !important;
    }

    .group:hover span {
        color: #fff !important;
        transform: translateY(2px);
        transition: all 0.3s ease;
    }

    /* Professional Tech Enhancements */
    .hero-mesh {
        position: absolute;
        inset: 0;
        background-image: 
            linear-gradient(to right, rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 50px 50px;
        mask-image: radial-gradient(circle at 50% 50%, black 30%, transparent 80%);
        pointer-events: none;
        z-index: 1;
    }

    /* Ultra Premium Desktop Enhancements */
    @media (min-width: 769px) {
        .hero-spotlight {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 50% 50%, rgba(251, 191, 36, 0.1) 0%, transparent 80%);
            pointer-events: none;
            z-index: 1;
        }
        
        .glass-card-premium {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.02)) !important;
            backdrop-filter: blur(24px) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 
                0 30px 60px rgba(0, 0, 0, 0.5), 
                inset 0 0 0 1px rgba(255, 255, 255, 0.05) !important;
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1) !important;
            position: relative;
        }

        .glass-card-premium::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, transparent 50%, rgba(255,255,255,0.1) 50%);
            border-top-right-radius: inherit;
        }
        
        .glass-card-premium:hover {
            border-color: rgba(251, 191, 36, 0.3) !important;
            transform: translateY(-10px) scale(1.02) !important;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.7) !important;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03)) !important;
        }

        .elite-dock {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(32px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 2.5rem;
            padding: 2.5rem;
            width: 100%;
            max-width: 1300px;
            box-shadow: 
                0 60px 120px -30px rgba(0,0,0,0.6),
                inset 0 1px 1px rgba(255,255,255,0.05);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            transition: all 0.4s ease;
        }

        .dock-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .dock-item-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 1.25rem;
            padding: 1.25rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            transition: all 0.3s ease;
            min-width: 0;
        }

        .dock-item-card:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        .item-icon-box {
            width: 3.5rem;
            height: 3.5rem;
            background: rgba(15, 23, 42, 0.6);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    }
</style>

<!-- ELITE HERO SECTION -->
<section id="beranda" class="elite-hero overflow-hidden pb-6 md:pb-0 relative">
    <!-- MOBILE PROFILE HEADER INSIDE -->
    <div class="md:hidden bg-transparent absolute top-0 left-0 right-0 pt-10 pb-4 px-6 z-30" x-data="{ showProfileMenu: false, showProfilePic: false }">
        <div class="flex items-center gap-4 relative">
            <div class="relative cursor-pointer" @click="showProfileMenu = !showProfileMenu">
                <img src="{{ isset($profile) && $profile->logo ? asset('storage/' . $profile->logo) : (\App\Models\Profile::first()?->logo ? asset('storage/' . \App\Models\Profile::first()->logo) : asset('log polri.png')) }}" class="w-16 h-16 rounded-full border border-white/10 shadow-2xl object-contain" alt="Logo">
            </div>
            <div class="cursor-pointer flex-1" @click="showProfileMenu = !showProfileMenu">
                <h3 class="text-xl font-black text-white uppercase tracking-wider font-outfit">{{ Auth::user()->name ?? 'PENGUNJUNG' }}</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">BIRO LOGISTIK POLDA NTB</p>
            </div>
            <div @click="showProfileMenu = !showProfileMenu" class="text-white bg-white/10 p-2.5 rounded-xl border border-white/20 shadow-lg cursor-pointer flex-shrink-0 transition-all active:scale-95 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </div>

            <!-- Dropdown Menu -->
            <div x-show="showProfileMenu" @click.away="showProfileMenu = false" x-transition class="absolute top-full right-0 mt-2 w-56 bg-[#1e293b]/95 backdrop-blur-md rounded-xl shadow-2xl border border-white/10 overflow-hidden z-50 origin-top-right">
                <button @click="showProfilePic = true; showProfileMenu = false" class="w-full text-left px-5 py-4 text-sm text-white hover:bg-white/10 border-b border-white/5 font-semibold flex items-center gap-3 transition-colors">
                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    Lihat Profil
                </button>
                <a href="{{ route('login') }}" class="w-full text-left px-5 py-4 text-sm text-white hover:bg-white/10 font-semibold flex items-center gap-3 transition-colors">
                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    Login Portal
                </a>
            </div>
        </div>

        <!-- Full Profile Picture Modal -->
        <template x-teleport="body">
            <div x-show="showProfilePic" x-transition.opacity class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-md flex items-center justify-center p-6" style="display: none;">
                <button @click="showProfilePic = false" class="absolute top-8 right-6 text-white hover:text-amber-500 p-2 bg-white/10 rounded-full transition-colors z-10">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
                <img src="{{ isset($profile) && $profile->logo ? asset('storage/' . $profile->logo) : (\App\Models\Profile::first()?->logo ? asset('storage/' . \App\Models\Profile::first()->logo) : asset('log polri.png')) }}" class="max-w-full max-h-[70vh] object-contain rounded-[2rem] border border-white/10 shadow-2xl" @click.away="showProfilePic = false">
            </div>
        </template>
    </div>
    <div class="max-w-[1600px] mx-auto px-6 md:px-8 relative z-20 w-full pt-36 md:pt-20">
        
        <!-- Desktop Header: Logo above SILOGIS (Desktop Only) -->
        <div class="hidden flex-col items-center mb-8">
            <img src="{{ isset($profile) && $profile->logo ? asset('storage/' . $profile->logo) : (\App\Models\Profile::first()?->logo ? asset('storage/' . \App\Models\Profile::first()->logo) : asset('log polri.png')) }}" class="w-16 h-auto mb-4 filter drop-shadow-[0_10px_30px_rgba(251,191,36,0.3)] animate-float">
            <h1 class="text-8xl font-black uppercase font-outfit tracking-[0.1em] leading-none text-center pl-[0.1em]">
                <span class="elite-shimmer-effect drop-shadow-2xl">SILOGIS</span>
            </h1>
        </div>

        <!-- Parallel Column Layout (Desktop Only) -->
        <div class="hidden lg:grid grid-cols-12 gap-10 w-full mt-10 mb-20 items-start">
            
            <!-- LEFT COLUMN: Visi & Misi Stacked -->
            <div class="lg:col-span-5 flex flex-col gap-6">
                <div class="glass-card-premium p-8 rounded-[2.5rem] overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1.5 h-1/3 bg-amber-500 opacity-70 group-hover:h-full transition-all duration-700"></div>
                    <div class="absolute top-0 left-0 w-1/4 h-1.5 bg-amber-500 opacity-70 group-hover:w-full transition-all duration-700"></div>
                    
                    <h4 class="text-amber-500 font-black uppercase tracking-[0.4em] text-[10px] mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                        Visi Kami
                    </h4>
                    <p class="text-white text-base font-black italic leading-relaxed drop-shadow-lg">"{{ $profile?->vision ?? 'Terwujudnya logistik yang modern, profesional dan terpercaya.' }}"</p>
                </div>

                <div class="glass-card-premium p-8 rounded-[2.5rem] overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1.5 h-1/3 bg-red-600 opacity-70 group-hover:h-full transition-all duration-700"></div>
                    <div class="absolute top-0 left-0 w-1/4 h-1.5 bg-red-600 opacity-70 group-hover:w-full transition-all duration-700"></div>
                    
                    <h4 class="text-red-500 font-black uppercase tracking-[0.4em] text-[10px] mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-red-600 rounded-full animate-pulse"></span>
                        Misi Kami
                    </h4>
                    <div class="text-white text-[11px] font-bold italic space-y-3 leading-relaxed drop-shadow-md">
                        {!! nl2br(e($profile?->mission ?? 'Mewujudkan tata kelola logistik yang transparan dan akuntabel.')) !!}
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: Digital Ecosystem Hub -->
            <div class="lg:col-span-7">
                <div class="elite-dock transform hover:scale-[1.01] w-full">
                    <div class="dock-header">
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <div class="w-3 h-3 bg-blue-500 rounded-full shadow-[0_0_15px_rgba(59,130,246,1)]"></div>
                                <div class="absolute inset-0 w-3 h-3 bg-blue-500 rounded-full animate-ping opacity-30"></div>
                            </div>
                            <h2 class="text-white font-black text-sm uppercase tracking-[0.2em]">Layanan Digital</h2>
                        </div>
                        <button type="button" @click.prevent="showAllServices = true" class="px-4 py-1.5 bg-white/5 hover:bg-amber-500 hover:text-[#0f172a] transition-colors cursor-pointer rounded-full border border-white/10 text-[9px] font-black text-amber-500 hover:text-[#0f172a] uppercase tracking-widest">
                            Akses Cepat
                        </button>
                    </div>
                    
                    <!-- Grid 3x2 for Apps in this side layout -->
                    <div class="grid grid-cols-3 gap-4">
                        <!-- HARDCODED WBS MENU (At Position 1) -->
                        <a href="{{ route('portal.bws.index') }}" class="dock-item-card group">
                            <div class="item-icon-box bg-slate-800 border-slate-700 group-hover:bg-[#1e293b] group-hover:border-amber-500/50 transition-colors shadow-lg group-hover:shadow-[0_15px_30px_-10px_rgba(245,158,11,0.4)]">
                                @if($profile && $profile->bws_logo)
                                    <img src="{{ asset('storage/' . $profile->bws_logo) }}" class="w-full h-full object-contain p-1" alt="WBS">
                                @else
                                    <svg class="w-10 h-10 text-amber-500 group-hover:scale-110 group-hover:-translate-y-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                @endif
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[13px] font-black text-white uppercase tracking-tight group-hover:text-amber-500 transition-colors truncate">WBS</span>
                                <span class="text-[10px] font-bold text-slate-400 italic truncate opacity-70 group-hover:opacity-100 transition-opacity">Pengaduan</span>
                            </div>
                        </a>

                        @foreach ($apps->take(4) as $app)
                            <a href="{{ $app->url }}" target="_blank" class="dock-item-card group">
                                <div class="item-icon-box">
                                    @if($app->icon)
                                        <img src="{{ asset('storage/' . $app->icon) }}" class="w-full h-full object-contain p-1" alt="{{ $app->title }}">
                                    @else
                                        <svg class="w-10 h-10 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                    @endif
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <span class="text-[13px] font-black text-white uppercase tracking-tight group-hover:text-amber-500 transition-colors truncate">{{ $app->title }}</span>
                                    <span class="text-[10px] font-bold text-slate-400 italic truncate opacity-70 group-hover:opacity-100 transition-opacity">{{ $app->description ?? 'Layanan Digital' }}</span>
                                </div>
                            </a>
                        @endforeach

                        <button type="button" @click.prevent="showAllServices = true" class="dock-item-card group cursor-pointer text-left">
                            <div class="item-icon-box bg-amber-500/10 border-amber-500/20 group-hover:bg-amber-500 transition-colors">
                                <svg class="w-6 h-6 text-amber-500 group-hover:text-[#0f172a] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-[13px] font-black text-amber-500 uppercase tracking-tight group-hover:text-white transition-colors truncate">Lainnya</span>
                                <span class="text-[10px] font-bold text-amber-500/60 italic truncate">Menu Tambahan</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile & Legacy Grid (Hidden on LG for new symmetrical layout) -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start lg:hidden">
            
            <!-- LEFT: Visi Misi (Reduced width on Desktop) -->
            <div class="lg:col-span-4 hidden lg:flex flex-col gap-4">
                <div class="glass-card-premium p-8 rounded-[2.5rem] relative group overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-amber-500 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <h4 class="text-amber-500 font-black uppercase tracking-[0.3em] text-[10px] mb-4">Visi Kami</h4>
                    <p class="text-white text-base font-black italic leading-relaxed">"{{ $profile?->vision ?? 'Terwujudnya logistik yang modern, profesional dan terpercaya.' }}"</p>
                </div>
                <div class="glass-card-premium p-8 rounded-[2.5rem] border-l-4 border-red-600/50 relative group overflow-hidden">
                    <div class="absolute top-0 left-0 w-1 h-full bg-red-600 opacity-50 group-hover:opacity-100 transition-opacity"></div>
                    <h4 class="text-red-500 font-black uppercase tracking-[0.3em] text-[10px] mb-4">Misi Kami</h4>
                    <div class="text-white text-[12px] font-bold italic space-y-3 leading-relaxed">
                        {!! nl2br(e($profile?->mission ?? 'Mewujudkan tata kelola logistik yang transparan dan akuntabel.')) !!}
                    </div>
                </div>
            </div>

            <!-- CENTER: Main Title (MOBILE ONLY) -->
            <div class="lg:col-span-6 text-center md:hidden mt-12">
                <h1 class="text-7xl font-black uppercase font-outfit tracking-tighter leading-none mb-4">
                    <span class="elite-shimmer-effect drop-shadow-2xl px-2">SILOGIS</span>
                </h1>
                <p class="text-[13px] font-black italic text-white uppercase font-outfit tracking-[0.1em] mb-0 drop-shadow-lg whitespace-nowrap">
                    Sistem Informasi Logistik
                </p>
            </div>

            <!-- RIGHT: App Dock (Portal Layout from Image) -->
            <div class="lg:col-span-8 hidden lg:flex items-center justify-center pt-8">
                <!-- Keep original for safety/mobile but LG hidden now handles the new layout -->
            </div>

            <!-- MOBILE App Dock Placeholder -->
            <div class="md:hidden">
                <!-- Keep mobile logic -->
            </div>
        </div>
    </div>
</section>

<!-- ELITE HUB: Layanan Digital -->
<section id="layanan" class="pt-6 md:pt-16 pb-1 md:pb-16 bg-[#0f172a] px-6 relative md:hidden">
    <div class="max-w-[1200px] mx-auto">
        <!-- Section Header Mobile -->
        <div class="mb-6 border-b border-white/10 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]"></div>
                <h2 class="text-xl font-black text-white tracking-wider uppercase font-outfit">Layanan Digital</h2>
            </div>
            <span class="block text-[9px] font-bold text-amber-500/60 uppercase tracking-[0.3em] mt-2 ml-5">Digital Ecosystem</span>
        </div>

        <!-- Mobile Grid (Icons) -->
        <div class="grid grid-cols-4 gap-y-10 mb-12">
            <!-- HARDCODED WBS MENU (At Position 1) -->
            <a href="{{ route('portal.bws.index') }}" class="flex flex-col items-center gap-3 reveal-on-scroll group">
                <div class="w-16 h-16 bg-slate-800 rounded-[1.5rem] flex items-center justify-center text-amber-500 border border-slate-700 shadow-xl elite-icon-container transition-all duration-300">
                    @if($profile && $profile->bws_logo)
                        <img src="{{ asset('storage/' . $profile->bws_logo) }}" class="w-full h-full object-contain p-1" alt="WBS">
                    @else
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    @endif
                </div>
                <span class="text-[9px] font-black text-slate-300 text-center leading-tight uppercase tracking-tighter transition-all">WBS</span>
            </a>

            @foreach ($apps->take(2) as $app)
                <a href="{{ $app->url }}" target="_blank" class="flex flex-col items-center gap-3 reveal-on-scroll group">
                    <div class="w-16 h-16 bg-slate-800 rounded-[1.5rem] flex items-center justify-center text-amber-500 border border-slate-700 shadow-xl elite-icon-container transition-all duration-300" style="animation-delay: {{ $loop->index * 200 }}ms">
                        @if($app->icon)
                            <img src="{{ asset('storage/' . $app->icon) }}" class="w-full h-full object-contain p-1" alt="">
                        @else
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        @endif
                    </div>
                    <span class="text-[9px] font-black text-slate-300 text-center leading-tight uppercase tracking-tighter transition-all">{{ $app->title }}</span>
                </a>
            @endforeach
            <button type="button" @click.prevent="showAllServices = true" class="flex flex-col items-center gap-3 group">
                <div class="w-16 h-16 bg-amber-500 rounded-[1.5rem] flex items-center justify-center text-[#0f172a] shadow-xl shadow-amber-500/20 elite-icon-container transition-all duration-300">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                </div>
                <span class="text-[9px] font-black text-amber-500 text-center uppercase transition-all">Lainnya</span>
            </button>
        </div>
    </div>
</section>

<!-- ELITE NEWS: Instagram Feed -->
<section id="berita" class="pt-6 md:pt-16 pb-1 md:pb-16 bg-[#0f172a] px-6 md:px-8">
    <div class="max-w-[1200px] mx-auto">
        <!-- Section Header Mobile -->
        <div class="md:hidden mb-6 border-b border-white/10 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]"></div>
                <h2 class="text-xl font-black text-white tracking-wider uppercase font-outfit">Berita Utama</h2>
            </div>
            <span class="block text-[9px] font-bold text-amber-500/60 uppercase tracking-[0.3em] mt-2 ml-5">Polda NTB Updates</span>
        </div>

        <!-- Header Desktop -->
        <div class="hidden md:flex items-center justify-between mb-12">
            <div class="space-y-2">
                <span class="text-amber-500 font-black uppercase tracking-[0.4em] text-[10px] flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>Polda NTB Updates</span>
                <h2 class="text-4xl font-black uppercase font-outfit leading-tight text-white drop-shadow-sm">Berita Utama</h2>
            </div>
            <a href="https://www.instagram.com/birologistik_ntb/" target="_blank" class="flex items-center gap-3 px-6 py-3 bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] text-white text-[10px] font-black rounded-xl shadow-xl hover:scale-105 transition-all uppercase italic">
                Follow IG @birologistik_ntb
            </a>
        </div>

        <!-- Mobile List -->
        <div class="md:hidden space-y-6 mb-12" x-data="{ showAllNews: false }">
            @foreach($news->take(3) as $post)
                <a href="{{ route('portal.news.show', $post->slug) }}" class="bg-slate-800/40 p-4 rounded-[2rem] flex items-center gap-5 border border-white/5 transition-all duration-300 transform hover:scale-[1.03] hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(0,0,0,0.5)] hover:border-amber-500/30 hover:bg-slate-800 active:scale-95 cursor-pointer block">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-24 h-24 rounded-2xl object-cover shadow-2xl transition-transform duration-500 group-hover:scale-105" alt="">
                    <div class="flex-1">
                        <span class="text-[8px] font-black text-amber-500 uppercase tracking-widest block mb-2">{{ $post->created_at->format('d M Y') }}</span>
                        <h4 class="text-[11px] font-black text-white uppercase leading-tight line-clamp-3 font-outfit">{{ $post->title }}</h4>
                        <div class="mt-3 flex flex-wrap items-center gap-3">
                            <div class="flex items-center gap-1.5 text-amber-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                <span class="text-[8px] font-black uppercase">Baca Berita</span>
                            </div>
                            @if($post->instagram_url)
                                <button @click.prevent="window.open('{{ $post->instagram_url }}', '_blank')" class="flex items-center gap-1.5 text-[#ee2a7b] z-10 relative px-2 py-1 bg-[#ee2a7b]/10 rounded-lg border border-[#ee2a7b]/20 hover:bg-[#ee2a7b] hover:text-white transition-colors">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.247 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.061 1.366-.333 2.633-1.308 3.608-.975.975-2.242 1.247-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.061-2.633-.333-3.608-1.308-.975-.975-1.247-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.061-1.366.333-2.633 1.308-3.608.975-.975 2.242-1.247 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.62.074-2.812.333-3.846 1.367-1.037 1.034-1.295 2.225-1.369 3.846-.058 1.28-.072 1.688-.072 4.947s.014 3.667.072 4.947c.074 1.621.332 2.812 1.369 3.846 1.034 1.037 2.225 1.295 3.846 1.369 1.28.058 1.688.072 4.947.072s3.667-.014 4.947-.072c1.621-.074 2.812-.332 3.846-1.369 1.037-1.034 1.295-2.225 1.369-3.846.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.074-1.621-.332-2.812-1.369-3.846-1.034-1.037-2.225-1.295-3.846-1.369-1.28-.058-1.688-.072-4.947-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    <span class="text-[8px] font-black uppercase">Buka IG</span>
                                </button>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach

            @if($news->count() > 3)
                <a href="{{ route('portal.news.index') }}" class="w-full py-4 mt-2 border border-amber-500/30 text-amber-500 rounded-[2rem] font-black uppercase text-[10px] tracking-widest hover:bg-amber-500 hover:text-[#0f172a] transition-colors shadow-[0_0_15px_rgba(245,158,11,0.2)] flex items-center justify-center">
                    Semua Berita
                </a>
            @endif
        </div>

        <!-- Desktop Grid -->
        <div class="hidden md:grid grid-cols-4 gap-8">
            @foreach ($news as $item)
                <a href="{{ $item->instagram_url ? $item->instagram_url : route('portal.news.show', $item->slug) }}"
                   @if($item->instagram_url) target="_blank" @endif
                   class="news-card-elite group cursor-pointer flex flex-col reveal-on-scroll overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 rounded-3xl border border-white/5" style="transition-delay: {{ $loop->index * 150 }}ms;">
                    <div class="relative aspect-[4/3] w-full overflow-hidden shrink-0">
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-700" alt="">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-5">
                            <span class="text-white text-[10px] font-black uppercase tracking-widest flex items-center gap-2">Baca Selengkapnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg></span>
                        </div>
                        <div class="absolute top-4 left-4">
                            @if($item->instagram_url)
                                <span class="px-3 py-1.5 bg-white/20 backdrop-blur-md text-white text-[9px] font-black rounded-lg border border-white/20 uppercase shadow-lg flex items-center gap-1.5"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163...z"/></svg>INSTAGRAM</span>
                            @else
                                <span class="px-3 py-1.5 bg-red-600/90 backdrop-blur-md text-white text-[9px] font-black rounded-lg border border-red-500/50 uppercase shadow-lg shadow-red-500/20">ARTIKEL</span>
                            @endif
                        </div>
                    </div>
                    <div class="p-6 bg-slate-800/40 flex-1 flex flex-col justify-between border-t border-white/5">
                        <div>
                            <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest flex items-center gap-1.5 mb-3">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> 
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                            <h4 class="text-sm font-black text-white uppercase line-clamp-2 leading-snug font-outfit group-hover:text-amber-500 transition-colors">{{ $item->title }}</h4>
                            @if(!empty($item->content) && !$item->instagram_url)
                                <p class="text-[11px] text-slate-400 mt-3 line-clamp-3 leading-relaxed font-medium">{!! Str::limit(strip_tags($item->content), 120) !!}</p>
                            @endif
                        </div>
                        <div class="w-8 h-1 bg-white/10 group-hover:bg-amber-500 group-hover:w-full transition-all duration-500 mt-6 rounded-full"></div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- ELITE DOKUMEN: Dokumen & Arsip -->
<section id="dokumen" class="pt-6 md:pt-16 pb-1 md:pb-16 bg-[#0f172a] px-6 md:px-8">
    <div class="max-w-[1200px] mx-auto">
        <!-- Section Header Mobile -->
        <div class="md:hidden mb-6 border-b border-white/10 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]"></div>
                <h2 class="text-xl font-black text-white tracking-wider uppercase font-outfit">Dokumen</h2>
            </div>
            <span class="block text-[9px] font-bold text-amber-500/60 uppercase tracking-[0.3em] mt-2 ml-5">Data & Archives Center</span>
        </div>

        <!-- Header Desktop -->
        <div class="hidden md:flex flex-row items-end justify-between mb-16 gap-8">
            <div class="space-y-4">
                <span class="text-amber-500 font-black uppercase tracking-[0.4em] text-[10px] flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>Data & Archives Center</span>
                <h2 class="text-4xl font-black uppercase font-outfit leading-tight text-white drop-shadow-sm">Dokumen</h2>
            </div>
            <div class="w-full max-w-sm">
                <div class="relative group">
                    <input type="text" x-model="searchDoc" placeholder="Cari Dokumen..." class="w-full bg-slate-800/50 border border-white/10 text-white rounded-2xl py-4 pl-12 pr-6 text-sm font-bold focus:outline-none focus:ring-2 focus:ring-amber-500 transition-all placeholder-slate-500">
                    <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Mobile Quick Access Icons -->
        <div class="md:hidden grid grid-cols-4 gap-y-10 mb-16">
            @foreach ($folders->take(3) as $folder)
                <div x-data="{ openFolder: false }">
                    <button type="button" @click.prevent="openFolder = true" class="w-full flex flex-col items-center gap-3 reveal-on-scroll group focus:outline-none">
                        <div class="w-16 h-16 bg-slate-800 rounded-[1.5rem] flex items-center justify-center text-amber-500 border border-slate-700 shadow-xl elite-icon-container transition-all duration-300" style="animation-delay: {{ $loop->index * 200 }}ms">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                        </div>
                        <span class="text-[9px] font-black text-slate-300 text-center leading-tight uppercase tracking-tighter transition-all">{{ $folder->name }}</span>
                    </button>

                    <!-- Modal Folder Details -->
                    <template x-teleport="body">
                        <div x-show="openFolder" x-cloak class="fixed inset-0 z-[99999] flex items-center justify-center p-6 bg-[#0f172a]/95 backdrop-blur-md" @click.self="openFolder = false" x-transition.opacity.duration.300ms>
                            <div x-show="openFolder" class="bg-slate-900 border border-white/10 rounded-[2.5rem] p-6 w-full max-w-sm relative shadow-2xl flex flex-col max-h-[80vh]" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                                <button type="button" @click.prevent="openFolder = false" class="absolute top-4 right-4 h-10 w-10 bg-slate-800 rounded-full flex items-center justify-center text-slate-400 hover:text-white transition-colors z-10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                
                                <div class="flex items-center gap-4 mb-6 pr-12">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-white/5 flex items-center justify-center text-amber-500 shadow-inner shrink-0">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-black text-white uppercase tracking-widest leading-tight">{{ $folder->name }}</h3>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">{{ $folder->documents->count() }} Berkas</p>
                                    </div>
                                </div>

                                @if($folder->documents->count() > 0)
                                <a href="{{ route('portal.folders.download', $folder->id) }}" class="w-full py-3 mb-4 bg-amber-500 text-[#0f172a] rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 shadow-lg shadow-amber-500/20 active:scale-95 transition-transform shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Download Semua (.zip)
                                </a>
                                @endif

                                <div class="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar">
                                    @forelse($folder->documents as $doc)
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="flex items-center justify-between p-4 bg-slate-800/50 rounded-2xl border border-white/5 hover:bg-slate-800 transition-colors group">
                                            <div class="flex items-center gap-3 overflow-hidden">
                                                <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                <span class="text-[11px] font-bold text-slate-300 truncate group-hover:text-white transition-colors">{{ $doc->title }}</span>
                                            </div>
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-amber-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                    @empty
                                        <div class="p-6 text-center text-slate-500 text-xs font-bold italic">
                                            Belum ada berkas di folder ini.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @endforeach

            @if($folders->count() > 3 || $standaloneDocuments->count() > 0)
                <button type="button" @click.prevent="showAllDocs = true" class="flex flex-col items-center gap-3 group">
                    <div class="w-16 h-16 bg-amber-500 rounded-[1.5rem] flex items-center justify-center text-[#0f172a] shadow-xl shadow-amber-500/20 elite-icon-container transition-all duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    </div>
                    <span class="text-[9px] font-black text-amber-500 text-center uppercase transition-all">Semua</span>
                </button>
            @endif
        </div>


        <!-- Desktop View (Grid) -->
        <div class="hidden md:grid grid-cols-6 gap-5">
            <!-- Folders -->
            @foreach ($folders->take(11) as $folder)
                <div class="bg-slate-800/40 p-4 rounded-3xl border border-white/5 group shadow-sm hover:shadow-2xl hover:border-amber-500/30 transition-all duration-500 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <div class="h-10 w-10 bg-slate-900 border border-white/10 rounded-xl flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                            </div>
                            <span class="text-[8px] font-black text-amber-500 bg-amber-500/10 border border-amber-500/20 px-2 py-1 rounded-full uppercase tracking-widest">{{ $folder->documents->count() }} Berkas</span>
                        </div>
                        <h4 class="text-[10px] font-black text-white uppercase mb-3 line-clamp-2 leading-snug font-outfit group-hover:text-amber-500 transition-colors">{{ $folder->name }}</h4>
                    </div>
                    
                    @if($folder->documents->count() > 0)
                        <a href="{{ route('portal.folders.download', $folder->id) }}" class="w-full mt-2 py-2.5 bg-gradient-to-r from-amber-500 to-amber-400 text-slate-900 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center justify-center gap-1.5 shadow-md hover:shadow-[0_0_15px_rgba(245,158,11,0.5)] hover:-translate-y-0.5 transition-all">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            .zip
                        </a>
                    @else
                        <div class="w-full mt-2 py-2.5 bg-slate-800 text-slate-500 rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center justify-center gap-1.5 border border-white/5 cursor-not-allowed">
                            Kosong
                        </div>
                    @endif
                </div>
            @endforeach

            @if($folders->count() > 11)
                <button type="button" @click.prevent="showAllDocs = true" class="bg-slate-800/20 border border-white/5 p-4 rounded-3xl group shadow-sm hover:shadow-2xl hover:border-amber-500/30 transition-all duration-500 flex flex-col justify-center items-center text-center">
                    <div class="h-10 w-10 bg-amber-500 rounded-full flex items-center justify-center text-[#0f172a] mb-3 shadow-[0_0_15px_rgba(245,158,11,0.4)] group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                    </div>
                    <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest line-clamp-2">Lihat Semua<br>Folder</span>
                </button>
            @endif

            <!-- Standalone Documents -->
            @foreach ($standaloneDocuments as $doc)
                <div class="bg-slate-900 p-4 rounded-3xl group hover:scale-[1.02] transition-all duration-500 flex flex-col justify-between">
                    <div>
                        <div class="h-10 w-10 bg-white/10 rounded-xl flex items-center justify-center text-white mb-4">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        </div>
                        <h4 class="text-[10px] font-black text-white uppercase mb-4 line-clamp-2 font-outfit leading-snug">{{ $doc->title }}</h4>
                    </div>
                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="w-full py-2.5 bg-amber-500 text-[#0f172a] rounded-lg text-[9px] font-black uppercase tracking-widest flex items-center justify-center gap-1.5 shadow-md hover:shadow-lg italic transition-all">
                        Unduh Mandiri
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ELITE BAGIAN: Tupoksi/Fungsi -->
<section id="bagian" class="pt-6 md:pt-16 pb-1 md:pb-16 bg-[#0f172a] px-6 md:px-8 relative overflow-hidden">
    <div class="max-w-[1200px] mx-auto">
        <!-- Header Mobile -->
        <div class="md:hidden mb-6 border-b border-white/10 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]"></div>
                <h2 class="text-xl font-black text-white tracking-wider uppercase font-outfit">Bagian/Fungsi</h2>
            </div>
            <span class="block text-[9px] font-bold text-amber-500/60 uppercase tracking-[0.3em] mt-2 ml-5">Tugas Pokok & Fungsi</span>
        </div>



        <!-- Mobile List -->
        <div class="md:hidden space-y-5 mb-16">
            @foreach ($bagians as $sec)
                @php
                    $bagName = strtolower(trim($sec->name));
                    $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />'; // Default: Building
                    if (str_contains($bagName, 'subbagrenmin')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />'; }
                    elseif (str_contains($bagName, 'bag pal')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />'; }
                    elseif (str_contains($bagName, 'bag infolog')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />'; }
                    elseif (str_contains($bagName, 'bag ada')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /><polyline stroke-linecap="round" stroke-linejoin="round" points="3.27 6.96 12 12.01 20.73 6.96" /><line stroke-linecap="round" stroke-linejoin="round" x1="12" y1="22.08" x2="12" y2="12" />'; }
                    elseif (str_contains($bagName, 'bag bekum')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z" />'; }
                    elseif (str_contains($bagName, 'urgudang')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M22 8.36L12 2 2 8.36V22h20V8.36z" /><path stroke-linecap="round" stroke-linejoin="round" d="M10 12h4v10h-4z" /><path stroke-linecap="round" stroke-linejoin="round" d="M14 8h.01" /><path stroke-linecap="round" stroke-linejoin="round" d="M10 8h.01" />'; }
                @endphp
                <div x-data="{ open: false }">
                    <div @click="open = true" class="flex gap-5 bg-slate-800/40 p-5 rounded-[2.5rem] border border-white/5 shadow-2xl reveal-on-scroll group transition-all duration-300 transform hover:scale-[1.03] hover:-translate-x-2 hover:shadow-[0_20px_40px_rgba(245,158,11,0.15)] hover:border-amber-500/30 hover:bg-slate-800 active:scale-95 cursor-pointer">
                        <div class="w-16 h-16 rounded-2xl bg-slate-900 flex items-center justify-center text-red-500 border border-red-500/20 animate-float-soft transition-all duration-300 group-hover:scale-110 group-hover:rotate-3 shrink-0 group-hover:text-amber-500 group-hover:border-amber-500/30" style="animation-delay: {{ $loop->index * 300 }}ms">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                {!! $iconPath !!}
                            </svg>
                        </div>
                        <div class="flex-1 flex flex-col justify-center">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-xs font-black text-white uppercase tracking-widest">{{ $sec->name }}</h3>
                            </div>
                            <p class="text-[9px] text-slate-400 font-medium italic line-clamp-2 leading-relaxed">{{ $sec->description ?? 'Deskripsi belum ditambahkan.' }}</p>
                        </div>
                    </div>

                    <!-- Modal Detail Bagian -->
                    <template x-teleport="body">
                        <div x-show="open" x-cloak class="fixed inset-0 z-[99999] flex items-center justify-center p-6 bg-[#0f172a]/95 backdrop-blur-md" @click.self="open = false" x-transition.opacity.duration.300ms>
                            <div x-show="open" class="bg-slate-900 border border-white/10 rounded-[2.5rem] p-8 w-full max-w-sm relative shadow-2xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                                <button @click="open = false" class="absolute top-4 right-4 h-10 w-10 bg-slate-800 rounded-full flex items-center justify-center text-slate-400 hover:text-white transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <div class="w-16 h-16 rounded-2xl bg-slate-800 border border-red-500/20 flex items-center justify-center text-red-500 mb-6 shadow-inner">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        {!! $iconPath !!}
                                    </svg>
                                </div>
                                <h3 class="text-xl font-black text-white uppercase tracking-widest mb-4">{{ $sec->name }}</h3>
                                <p class="text-sm text-slate-300 font-medium italic leading-relaxed">{{ $sec->description ?? 'Deskripsi belum ditambahkan.' }}</p>
                            </div>
                        </div>
                    </template>
                </div>
            @endforeach
        </div>

        <!-- Desktop Grid -->
        <div class="hidden md:block">
            <div class="text-center mb-16">
                <span class="text-red-500 font-black uppercase tracking-[0.4em] text-[10px] mb-4 block">Tugas Pokok & Fungsi</span>
                <h2 class="text-5xl font-black text-white uppercase font-outfit italic">Bagian/Fungsi</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($bagians as $sec)
                    @php
                        $bagName = strtolower(trim($sec->name));
                        $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />'; // Default: Building
                        if (str_contains($bagName, 'subbagrenmin')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />'; }
                        elseif (str_contains($bagName, 'bag pal')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />'; }
                        elseif (str_contains($bagName, 'bag infolog')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" />'; }
                        elseif (str_contains($bagName, 'bag ada')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z" /><polyline stroke-linecap="round" stroke-linejoin="round" points="3.27 6.96 12 12.01 20.73 6.96" /><line stroke-linecap="round" stroke-linejoin="round" x1="12" y1="22.08" x2="12" y2="12" />'; }
                        elseif (str_contains($bagName, 'bag bekum')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M20.38 3.46L16 2a4 4 0 01-8 0L3.62 3.46a2 2 0 00-1.34 2.23l.58 3.47a1 1 0 00.99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 002-2V10h2.15a1 1 0 00.99-.84l.58-3.47a2 2 0 00-1.34-2.23z" />'; }
                        elseif (str_contains($bagName, 'urgudang')) { $iconPath = '<path stroke-linecap="round" stroke-linejoin="round" d="M22 8.36L12 2 2 8.36V22h20V8.36z" /><path stroke-linecap="round" stroke-linejoin="round" d="M10 12h4v10h-4z" /><path stroke-linecap="round" stroke-linejoin="round" d="M14 8h.01" /><path stroke-linecap="round" stroke-linejoin="round" d="M10 8h.01" />'; }
                    @endphp
                    <div class="bg-slate-800/40 p-10 rounded-[3rem] border border-white/5 shadow-sm hover:shadow-2xl hover:bg-slate-800/80 transition-all duration-500 group relative overflow-hidden flex flex-col h-full">
                        <div class="absolute -right-4 -top-4 w-32 h-32 bg-red-500/5 rounded-full blur-3xl group-hover:bg-red-500/20 transition-colors pointer-events-none"></div>
                        
                        <div class="flex items-center gap-5 border-b border-white/10 pb-5 mb-5 relative z-10">
                            <div class="w-14 h-14 rounded-xl bg-slate-900/80 flex items-center justify-center text-red-500 border border-red-500/20 shadow-inner group-hover:scale-110 group-hover:text-amber-500 group-hover:border-amber-500/30 transition-all duration-500 shrink-0">
                                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    {!! $iconPath !!}
                                </svg>
                            </div>
                            <h5 class="text-red-500 font-black uppercase tracking-widest text-sm m-0 leading-snug group-hover:text-amber-500 transition-colors">{{ $sec->name }}</h5>
                        </div>

                        <p class="text-slate-300 text-sm leading-relaxed font-medium italic relative z-10 flex-1">{{ $sec->description ?? 'Deskripsi belum ditambahkan.' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- ELITE STRUKTUR: Personnel Discovery -->
<section id="struktur" class="pt-6 md:pt-16 pb-1 md:pb-16 bg-[#0f172a] px-6 md:px-8">
    <div class="max-w-[1200px] mx-auto">
        <!-- Section Header Mobile -->
        <div class="md:hidden mb-6 flex items-center justify-between border-b border-white/10 pb-4">
            <div>
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]"></div>
                    <h2 class="text-xl font-black text-white tracking-wider uppercase font-outfit">Struktur</h2>
                </div>
                <span class="block text-[9px] font-bold text-amber-500/60 uppercase tracking-[0.3em] mt-2 ml-5">Command Center</span>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" onclick="document.getElementById('struktur-scroll').scrollBy({ left: -window.innerWidth, behavior: 'smooth' })" class="flex items-center justify-center h-10 w-10 bg-white/5 rounded-2xl text-white shadow-xl shrink-0 active:scale-95 transition-all border border-white/10">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                </button>
                <button type="button" onclick="document.getElementById('struktur-scroll').scrollBy({ left: window.innerWidth, behavior: 'smooth' })" class="flex items-center justify-center h-10 w-10 bg-amber-500 rounded-2xl text-[#0f172a] shadow-xl shrink-0 active:scale-95 transition-all">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

        <!-- Header Desktop -->
        <div class="hidden md:flex items-center justify-between mb-12">
            <div class="space-y-2">
                <span class="text-amber-500 font-black uppercase tracking-[0.4em] text-[10px]">Command Center</span>
                <h2 class="text-6xl font-black text-white uppercase font-outfit leading-none">Struktur</h2>
            </div>
        </div>

        @php
            $allPersonnels = \App\Models\Organogram::orderBy('order')->get();
            $colors = ['bg-[#fbbf24]', 'bg-[#dc2626]', 'bg-[#0f172a]'];
        @endphp

        <!-- Mobile Scroll (Discovery Style) -->
        <div id="struktur-scroll" class="md:hidden -mx-6 px-6 flex gap-5 overflow-x-auto pb-10 snap-x no-scrollbar">
            @foreach($allPersonnels as $index => $person)
                <div class="flex-shrink-0 w-[calc(100vw-3rem)] h-[450px] rounded-[3.5rem] relative overflow-hidden snap-center {{ $colors[$index % 3] }} shadow-2xl border border-white/5">
                    <div class="absolute inset-0">
                         @if($person->photo)
                            <img src="{{ asset('storage/' . $person->photo) }}" class="w-full h-full object-cover" alt="{{ $person->name }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/30 to-transparent"></div>
                         @else
                            <div class="w-full h-full flex items-center justify-center bg-black/40 backdrop-blur-md">
                                <div class="text-center">
                                    <svg class="w-24 h-24 text-white/10 mx-auto mb-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                    <span class="text-[10px] text-white/20 font-black uppercase tracking-widest">No Identity Photo</span>
                                </div>
                            </div>
                         @endif
                    </div>
                    <div class="absolute bottom-12 inset-x-0 px-10 text-center">
                        @if($person->rank)
                            <div class="text-amber-400 font-black uppercase tracking-[0.2em] text-[10px] mb-1 drop-shadow-lg">{{ $person->rank }}</div>
                        @endif
                        <h5 class="text-white font-black uppercase text-2xl drop-shadow-2xl font-outfit leading-tight mb-2">{{ $person->name }}</h5>
                        <div class="inline-block px-4 py-1.5 bg-amber-500 rounded-full text-[#0f172a] text-[10px] font-black uppercase tracking-widest">{{ $person->position }}</div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Desktop Grid -->
        <div class="hidden md:grid grid-cols-7 gap-x-2 gap-y-16">
            @foreach($allPersonnels as $person)
                <div class="reveal-on-scroll">
                    @include('components.org-card', ['node' => $person])
                </div>
            @endforeach
        </div>
    </div>
</section>



<!-- SEKSI TENTANG KAMI -->
<section id="tentang" class="pt-6 md:pt-16 pb-10 md:pb-24 bg-[#0f172a] px-6 md:px-8 relative overflow-hidden lg:hidden">
    <div class="absolute top-0 right-0 w-1/2 h-full bg-amber-500/5 -skew-x-12 translate-x-1/4"></div>
    <div class="max-w-[1200px] mx-auto relative z-10 w-full">
        <!-- Header Mobile -->
        <div class="md:hidden mb-6 border-b border-white/10 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]"></div>
                <h2 class="text-xl font-black text-white tracking-wider uppercase font-outfit">Tentang Kami</h2>
            </div>
            <span class="block text-[9px] font-bold text-amber-500/60 uppercase tracking-[0.3em] mt-2 ml-5">Biro Logistik Polda NTB</span>
        </div>

        <!-- Mobile Content -->
        <div class="md:hidden space-y-6">
            <div class="bg-slate-800/40 backdrop-blur-md p-8 rounded-[3.5rem] border border-white/5 shadow-2xl reveal-on-scroll group transition-all duration-500 active:scale-95 hover:border-amber-500/30">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h4 class="text-amber-500 font-black uppercase tracking-widest text-[10px]">Visi</h4>
                </div>
                <p class="text-slate-300 text-[11px] font-bold leading-relaxed italic text-justify opacity-90 group-hover:opacity-100 transition-opacity">
                    {{ $profile?->vision ?? 'Menjadi biro logistik yang unggul dalam pelayanan.' }}
                </p>
            </div>

            <div class="bg-slate-800/40 backdrop-blur-md p-8 rounded-[3.5rem] border border-white/5 shadow-2xl reveal-on-scroll group transition-all duration-500 active:scale-95 hover:border-red-500/30">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <h4 class="text-red-500 font-black uppercase tracking-widest text-[10px]">Misi</h4>
                </div>
                <p class="text-slate-300 text-[11px] font-bold leading-relaxed italic text-justify opacity-90 group-hover:opacity-100 transition-opacity">
                    {{ $profile?->mission ?? 'Melaksanakan manajemen logistik secara profesional.' }}
                </p>
            </div>

            @if($profile?->history)
            <div class="bg-slate-800/20 p-8 rounded-[3.5rem] border border-white/5 reveal-on-scroll">
                <h4 class="text-slate-500 font-black uppercase tracking-widest text-[10px] mb-4">Sejarah & Perjalanan</h4>
                <p class="text-slate-400 text-[10px] font-medium leading-relaxed italic line-clamp-4">
                    {{ $profile->history }}
                </p>
            </div>
            @endif
        </div>

        <!-- Desktop Content -->
        <div class="hidden md:block">
            <h2 class="text-6xl font-black text-white uppercase font-outfit mb-20 text-center">Biro Logistik Polda NTB</h2>
            <div class="grid grid-cols-12 gap-12">
                <div class="col-span-7 bg-slate-800/40 p-16 rounded-[4rem] shadow-2xl relative overflow-hidden group/card border border-white/5">
                    <div class="absolute top-0 left-0 w-2 h-full bg-red-500 group-hover/card:w-4 transition-all duration-500"></div>
                    <div class="space-y-12">
                        <div class="group/item hover:translate-x-4 transition-transform duration-500">
                            <div class="flex items-center gap-5 mb-4">
                                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 flex items-center justify-center text-amber-500 group-hover/item:scale-110 group-hover/item:bg-amber-500 group-hover/item:text-white transition-all duration-500 shadow-lg shadow-amber-500/5">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </div>
                                <h3 class="text-4xl font-black text-white uppercase italic font-outfit">Visi</h3>
                            </div>
                            <p class="text-slate-300 text-xl font-bold italic leading-relaxed text-justify border-l-4 border-white/10 pl-8 group-hover/item:border-amber-500 transition-colors">
                                {{ $profile?->vision ?? 'Menjadi biro logistik yang unggul dalam pelayanan.' }}
                            </p>
                        </div>
                        <div class="group/item hover:translate-x-4 transition-transform duration-500">
                            <div class="flex items-center gap-5 mb-4">
                                <div class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 group-hover/item:scale-110 group-hover/item:bg-red-500 group-hover/item:text-white transition-all duration-500 shadow-lg shadow-red-500/5">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <h3 class="text-4xl font-black text-white uppercase italic font-outfit">Misi</h3>
                            </div>
                            <p class="text-slate-300 text-base font-medium italic leading-relaxed text-justify border-l-4 border-white/10 pl-8 group-hover/item:border-red-500 transition-colors">
                                {{ $profile?->mission ?? 'Melaksanakan manajemen logistik secara profesional.' }}
                            </p>
                        </div>
                    </div>
                    <div class="pt-12 mt-12 border-t border-white/10 grid grid-cols-2 gap-10">
                        <div class="group/stat">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] block mb-4 group-hover/stat:text-red-500 transition-colors">Nilai Utama</span>
                            <p class="text-base font-black text-white italic uppercase">Profesionalisme & Integritas</p>
                        </div>
                        <div class="group/stat">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.4em] block mb-4 group-hover/stat:text-red-500 transition-colors">Wilayah Tugas</span>
                            <p class="text-base font-black text-white italic uppercase">Polda Nusa Tenggara Barat</p>
                        </div>
                    </div>
                </div>
                <div class="col-span-5 space-y-8">
                    <div class="bg-amber-500 p-12 rounded-[4rem] text-[#0f172a] shadow-2xl">
                        <h4 class="text-[10px] font-black uppercase tracking-[0.4em] mb-6 opacity-60">Filosofi Kerja</h4>
                        <p class="text-2xl font-black italic leading-snug">"{{ $profile?->quote ?? 'Melayani dengan hati, mengabdi dengan integritas.' }}"</p>
                    </div>
                    @if($profile?->values)
                    <div class="bg-slate-900 p-12 rounded-[4rem] border border-white/5 text-white">
                        <h4 class="text-[10px] font-black uppercase tracking-[0.4em] mb-6 text-red-500">Nilai Organisasi</h4>
                        <p class="text-sm font-medium italic opacity-80 leading-relaxed">
                            {{ $profile->values }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MODALS & OVERLAYS -->
<div id="instaModal" class="fixed inset-0 z-[100] hidden items-center justify-center md:p-4">
    <div onclick="closeInstaModal()" class="absolute inset-0 bg-slate-950/100 md:bg-slate-900/80 backdrop-blur-xl"></div>
    <div class="relative bg-white w-full h-full md:h-auto md:max-w-lg md:rounded-[3rem] shadow-2xl overflow-hidden flex flex-col">
        <button onclick="closeInstaModal()" class="absolute top-4 right-4 md:top-8 md:right-8 z-20 h-10 w-10 md:h-12 md:w-12 rounded-full bg-white/50 backdrop-blur-md md:bg-slate-100 flex items-center justify-center text-slate-700 md:text-slate-500 hover:bg-slate-200 transition-colors shadow-lg border border-black/10 md:border-transparent">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div id="instaContainer" class="flex-1 w-full md:aspect-[4/5] bg-slate-50 flex items-center justify-center">
            <div class="flex flex-col items-center gap-4">
                <div class="w-12 h-12 border-4 border-amber-500 border-t-transparent rounded-full animate-spin"></div>
                <span class="text-[10px] font-black uppercase text-slate-400 tracking-widest">Memuat Feed...</span>
            </div>
        </div>
    </div>
</div>

<!-- GLOBAL MOBILE OVERLAYS (FULLSCREEN) -->
<div x-show="showAllServices" x-cloak class="fixed inset-0 z-[9999] bg-[#0f172a] overflow-y-auto">
    <div class="sticky top-0 bg-[#0f172a]/95 backdrop-blur-md px-6 py-4 flex items-center justify-between border-b border-white/5">
        <button @click="showAllServices = false" class="h-10 w-10 bg-white/5 rounded-2xl flex items-center justify-center text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg></button>
        <h3 class="text-base font-black text-white uppercase font-outfit tracking-widest">Layanan</h3>
        <div class="w-10"></div>
    </div>
    <div class="p-8">
        <input type="text" x-model="searchService" placeholder="Cari Layanan Digital..." class="w-full bg-slate-800/50 border border-white/10 rounded-2xl py-5 px-6 text-white text-sm font-bold focus:ring-2 focus:ring-red-600 outline-none mb-10 transition-all">
        <div class="grid grid-cols-3 md:grid-cols-5 gap-8">
            <!-- HARDCODED WBS -->
            <a x-show="'wbs pengaduan'.includes(searchService.toLowerCase())" href="{{ route('portal.bws.index') }}" class="flex flex-col items-center gap-4 group">
                <div class="w-20 h-20 bg-slate-800 rounded-[2rem] flex items-center justify-center text-amber-500 border border-white/5 shadow-2xl elite-icon-container">
                    @if($profile && $profile->bws_logo)
                        <img src="{{ asset('storage/' . $profile->bws_logo) }}" class="w-full h-full object-contain p-1.5" alt="WBS">
                    @else
                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    @endif
                </div>
                <span class="text-[10px] font-black text-white text-center uppercase tracking-tighter leading-tight transition-all">WBS</span>
            </a>
            
            @foreach ($apps as $app)
                <a x-show="'{{ strtolower($app->title) }}'.includes(searchService.toLowerCase())" href="{{ $app->url }}" target="_blank" class="flex flex-col items-center gap-4 group">
                    <div class="w-20 h-20 bg-slate-800 rounded-[2rem] flex items-center justify-center text-amber-500 border border-white/5 shadow-2xl elite-icon-container">
                        @if($app->icon) <img src="{{ asset('storage/' . $app->icon) }}" class="w-full h-full object-contain p-1.5"> @else <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M13 10V3L4 14h7v7l9-11h-7z" /></svg> @endif
                    </div>
                    <span class="text-[10px] font-black text-white text-center uppercase tracking-tighter leading-tight transition-all">{{ $app->title }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<div x-show="showAllDocs" x-cloak class="fixed inset-0 z-[9999] bg-[#0f172a] overflow-y-auto">
    <div class="sticky top-0 bg-[#0f172a]/95 backdrop-blur-md px-6 py-4 flex items-center justify-between border-b border-white/5">
        <button @click="showAllDocs = false" class="h-10 w-10 bg-white/5 rounded-2xl flex items-center justify-center text-white"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg></button>
        <h3 class="text-base font-black text-white uppercase font-outfit tracking-widest">Dokumen</h3>
        <div class="w-10"></div>
    </div>
    <div class="p-8">
        <input type="text" x-model="searchDoc" placeholder="Cari Judul Berkas..." class="w-full bg-slate-800/50 border border-white/10 rounded-2xl py-5 px-6 text-white text-sm font-bold focus:ring-2 focus:ring-amber-500 outline-none mb-10 transition-all">
        
        <div class="grid grid-cols-3 gap-8 pb-20">
            <!-- Folders -->
            @foreach ($folders as $folder)
                <div x-show="'{{ strtolower($folder->name) }}'.includes(searchDoc.toLowerCase())" x-data="{ openGlobalFolder: false }">
                    <button type="button" @click.prevent="openGlobalFolder = true" class="flex flex-col items-center gap-4 group">
                        <div class="w-20 h-20 bg-slate-800 rounded-[2rem] flex items-center justify-center text-amber-500 border border-white/5 shadow-2xl elite-icon-container">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                        </div>
                        <span class="text-[10px] font-black text-white text-center uppercase tracking-tighter leading-tight transition-all">{{ $folder->name }}</span>
                    </button>

                    <!-- Modal Folder Details (Global Overlay) -->
                    <template x-teleport="body">
                        <div x-show="openGlobalFolder" x-cloak class="fixed inset-0 z-[999999] flex items-center justify-center p-6 bg-[#0f172a]/95 backdrop-blur-md" @click.self="openGlobalFolder = false" x-transition.opacity.duration.300ms>
                            <div x-show="openGlobalFolder" class="bg-slate-900 border border-white/10 rounded-[2.5rem] p-6 w-full max-w-sm relative shadow-2xl flex flex-col max-h-[80vh]" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100">
                                <button type="button" @click.prevent="openGlobalFolder = false" class="absolute top-4 right-4 h-10 w-10 bg-slate-800 rounded-full flex items-center justify-center text-slate-400 hover:text-white transition-colors z-10">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                
                                <div class="flex items-center gap-4 mb-6 pr-12">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-800 border border-white/5 flex items-center justify-center text-amber-500 shadow-inner shrink-0">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-black text-white uppercase tracking-widest leading-tight">{{ $folder->name }}</h3>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">{{ $folder->documents->count() }} Berkas</p>
                                    </div>
                                </div>

                                @if($folder->documents->count() > 0)
                                <a href="{{ route('portal.folders.download', $folder->id) }}" class="w-full py-3 mb-4 bg-amber-500 text-[#0f172a] rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center justify-center gap-2 shadow-lg shadow-amber-500/20 active:scale-95 transition-transform shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Download Semua (.zip)
                                </a>
                                @endif

                                <div class="flex-1 overflow-y-auto pr-2 space-y-3 custom-scrollbar">
                                    @forelse($folder->documents as $doc)
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="flex items-center justify-between p-4 bg-slate-800/50 rounded-2xl border border-white/5 hover:bg-slate-800 transition-colors group">
                                            <div class="flex items-center gap-3 overflow-hidden">
                                                <svg class="w-5 h-5 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                                <span class="text-[11px] font-bold text-slate-300 truncate group-hover:text-white transition-colors">{{ $doc->title }}</span>
                                            </div>
                                            <svg class="w-4 h-4 text-slate-500 group-hover:text-amber-500 transition-colors shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                        </a>
                                    @empty
                                        <div class="p-6 text-center text-slate-500 text-xs font-bold italic">
                                            Belum ada berkas di folder ini.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @endforeach

            <!-- Standalone Documents -->
            @foreach ($standaloneDocuments as $doc)
                <a x-show="'{{ strtolower($doc->title) }}'.includes(searchDoc.toLowerCase())" href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="flex flex-col items-center gap-4 group">
                    <div class="w-20 h-20 bg-slate-800 rounded-[2rem] flex items-center justify-center text-red-500 border border-white/5 shadow-2xl elite-icon-container elite-icon-red">
                        <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                    <span class="text-[10px] font-black text-white text-center uppercase tracking-tighter leading-tight transition-all">{{ $doc->title }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>

<script>
    function openInstaModal(url) {
        const modal = document.getElementById('instaModal');
        const container = document.getElementById('instaContainer');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        const shortcode = url.match(/(?:p|reel|reels|tv)\/([^\/?#&]+)/i)?.[1];
        if (shortcode) {
            container.innerHTML = `<iframe class="w-full h-full border-none" src="https://www.instagram.com/p/${shortcode}/embed" frameborder="0" scrolling="no" allowtransparency="true"></iframe>`;
        } else {
            container.innerHTML = `<div class="p-10 text-center"><p class="text-slate-500 font-black uppercase text-[10px] italic">Konten Media Tidak Tersedia</p></div>`;
        }
    }

    function closeInstaModal() {
        const modal = document.getElementById('instaModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }

    function updateDownloadLinkManual(url, folderId) {
        const btn = document.getElementById('download-' + folderId);
        if (url) {
            btn.href = url;
            btn.classList.remove('bg-slate-100', 'text-slate-300', 'pointer-events-none');
            btn.classList.add('bg-amber-500', 'text-[#0f172a]', 'shadow-lg', 'shadow-amber-500/20');
        } else {
            btn.href = '#';
            btn.classList.add('bg-slate-100', 'text-slate-300', 'pointer-events-none');
        }
    }
</script>

@push('modals')
@if(!\Illuminate\Support\Facades\Cookie::has('visitor_email'))
<div x-data="{ showVisitorModal: true }" x-show="showVisitorModal" x-cloak class="fixed inset-0 z-[9999999] flex items-center justify-center p-4 bg-[#0f172a]/95 backdrop-blur-md">
    <div class="bg-slate-900 border border-white/10 rounded-[2rem] p-8 w-full max-w-md relative shadow-2xl" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-4 border border-amber-500/20">
                <svg class="w-8 h-8 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
            <h3 class="text-xl font-black text-white uppercase font-outfit tracking-wider">Buku Tamu SILOGIS</h3>
            <p class="text-xs text-slate-400 mt-2 font-medium">Silakan isi form berikut untuk melanjutkan</p>
        </div>

        <form action="{{ route('visitor.register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1.5">Alamat Email Google</label>
                <input type="email" name="email" required placeholder="nama@gmail.com" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Nama Anda" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all">
            </div>
            <div>
                <label class="block text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1.5">Satuan Kerja (Opsional)</label>
                <input type="text" name="satuan_kerja" placeholder="Asal Satker" class="w-full bg-slate-800 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all">
            </div>
            <button type="submit" class="w-full py-4 bg-amber-500 hover:bg-amber-400 text-[#0f172a] font-black uppercase text-xs tracking-widest rounded-xl transition-all shadow-lg shadow-amber-500/20 mt-2">
                Simpan & Lanjutkan
            </button>
        </form>
    </div>
</div>
@endif
@endpush

</div>
@endsection
