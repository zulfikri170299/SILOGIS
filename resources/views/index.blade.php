@extends('layout')

@section('content')
<!-- Custom Modern CSS -->
<style>
    /* SILOGIS - Modern Light & High Contrast */
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

    .elite-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.9));
    }

    .grand-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(40px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 2rem;
        box-shadow: 0 20px 80px rgba(0, 98, 255, 0.08);
        position: relative;
        z-index: 10;
        overflow: hidden;
    }

    .grand-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #0062ff, transparent);
    }

    .service-tile {
        background: #ffffff;
        border: 1px solid #f1f5f9;
        border-radius: 1.5rem;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: row;
        align-items: center;
        text-align: left;
        gap: 1.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        min-height: 125px;
        transform-style: preserve-3d;
        perspective: 1000px;
        animation: card-float 8s ease-in-out infinite;
    }

    .service-tile:nth-child(even) {
        animation-delay: -3s;
    }

    @keyframes card-float {
        0%, 100% { transform: translateY(0) rotateX(0deg) rotateY(0deg); }
        50% { transform: translateY(-10px) rotateX(2deg) rotateY(1deg); }
    }

    .service-tile:hover {
        background: #dc2626; /* Red 600 */
        transform: translateY(-15px) rotateX(5deg) rotateY(2deg) scale(1.08);
        box-shadow: 0 40px 80px -15px rgba(220, 38, 38, 0.4);
        border-color: #dc2626;
        animation-play-state: paused;
    }

    .service-tile:hover h4,
    .service-tile:hover p,
    .service-tile:hover svg {
        color: white !important;
    }

    .service-tile:hover .tile-icon {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-color: rgba(255, 255, 255, 0.3);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .tile-icon {
        width: 75px;
        height: 75px;
        flex-shrink: 0;
        background: white;
        border-radius: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s ease;
        padding: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.03);
    }

    .service-tile:hover .tile-icon {
        background: white;
        color: #0062ff;
        transform: scale(1.1);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .news-card-elite {
        background: #ffffff;
        border: 1px solid #efefef;
        border-radius: 1.25rem;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.05);
        display: flex;
        flex-direction: column;
    }

    .news-card-elite:hover {
        transform: translateY(-8px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.12);
    }

    .ig-header {
        padding: 0.75rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .ig-badge {
        background: #e0eaff;
        color: #4338ca;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        font-weight: 800;
        font-size: 10px;
        letter-spacing: 0.05em;
    }

    .elite-glow {
        filter: drop-shadow(0 0 15px rgba(0, 98, 255, 0.3));
    }

    @keyframes shine {
        0% { left: -100%; }
        100% { left: 100%; }
    }
    .hover-shine:hover::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        animation: shine 0.6s;
    }

    .logo-3d-left, .logo-3d-right {
        position: absolute;
        top: 55%;
        transform: translateY(-50%) perspective(1000px);
        z-index: 5;
        pointer-events: none;
        opacity: 0.4;
    }

    .logo-3d-left { left: 5%; }
    .logo-3d-right { right: 5%; }

    .logo-3d {
        width: 180px;
        height: auto;
        filter: drop-shadow(15px 15px 30px rgba(0,0,0,0.2));
    }

    .logo-3d-left .logo-3d {
        transform: rotateY(25deg) rotateX(5deg);
        animation: logo-tilt-left 10s ease-in-out infinite;
    }

    .logo-3d-right .logo-3d {
        transform: rotateY(-25deg) rotateX(5deg);
        animation: logo-tilt-right 10s ease-in-out infinite;
    }

    @keyframes logo-tilt-left {
        0%, 100% { transform: rotateY(25deg) rotateX(5deg) scale(1); }
        50% { transform: rotateY(15deg) rotateX(2deg) scale(1.05); }
    }

    @keyframes logo-tilt-right {
        0%, 100% { transform: rotateY(-25deg) rotateX(5deg) scale(1); }
        50% { transform: rotateY(-15deg) rotateX(2deg) scale(1.05); }
    }
</style>


<!-- ELITE HERO SECTION -->
<section class="elite-hero mesh-gradient overflow-hidden">
    <!-- Floating Background Elements -->
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-brand-primary/20 blur-[120px] rounded-full animate-float"></div>
    <div class="absolute bottom-1/4 -right-20 w-[500px] h-[500px] bg-red-600/10 blur-[150px] rounded-full animate-float" style="animation-delay: -2s;"></div>

    <!-- 3D Background Logos -->
    <div class="logo-3d-left">
        <img src="{{ asset('Lambang_Polda_NTB.png') }}" class="logo-3d" alt="Lambang Polda NTB 3D">
    </div>
    <div class="logo-3d-right">
        <img src="{{ asset('log polri.png') }}" class="logo-3d" alt="POLRI 3D Logo Right">
    </div>

    <div class="max-w-7xl mx-auto px-8 relative z-20 text-center">
        <div class="reveal-on-scroll">
            <span class="inline-block px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-[10px] font-black uppercase tracking-[0.3em] mb-8">
                BIRO LOGISTIK POLDA NTB
            </span>
            <h1 class="text-6xl md:text-8xl font-black uppercase font-outfit tracking-[0.05em] leading-tight mb-6 reveal-on-scroll">
                <span class="elite-shimmer-effect px-2 py-4 filter drop-shadow-[0_5px_15px_rgba(220,38,38,0.4)]">SILOGIS</span>
            </h1>
            <p class="text-xl md:text-2xl font-black italic text-white uppercase font-outfit tracking-widest mb-10 opacity-90">
                Sistem Informasi Logistik
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="group relative px-10 py-5 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-red-600/20 italic">
                        <span class="relative z-10 flex items-center gap-2">Buka Dashboard &rarr;</span>
                        <div class="absolute inset-0 shimmer-effect opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="group relative px-10 py-5 bg-red-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-red-600/20 italic">
                        <span class="relative z-10">Akses Platform</span>
                        <div class="absolute inset-0 shimmer-effect opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </a>
                @endauth
                <a href="#layanan" class="group relative px-10 py-5 bg-brand-primary text-white rounded-2xl font-black uppercase tracking-widest text-xs overflow-hidden transition-all hover:scale-105 active:scale-95 shadow-2xl shadow-brand-primary/20 italic">
                    <span class="relative z-10">Aplikasi Logistik</span>
                    <div class="absolute inset-0 shimmer-effect opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ELITE HUB: Leader & Ecosystem -->
<section id="layanan" class="pt-4 pb-32 bg-white/40 backdrop-blur-md px-8 relative scroll-mt-32">
    <div class="max-w-[1440px] mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            <!-- Pimpinan Card - Compact Scale -->
            <div class="lg:col-span-3 relative group reveal-on-scroll">
                <div class="absolute -inset-10 bg-brand-primary/10 blur-[80px] rounded-full opacity-60"></div>
                <div class="relative bg-white/80 backdrop-blur-2xl border border-slate-200 shadow-2xl rounded-[2.5rem] p-5 overflow-hidden">
                    <div class="aspect-[4/4.2] w-full rounded-[1.5rem] overflow-hidden mb-4 border-4 border-slate-100 shadow-sm mx-auto">
                         <img src="{{ $profile->photo ? (str_contains($profile->photo, 'pimpinan.png') ? asset($profile->photo) : asset('storage/' . $profile->photo)) : asset('pimpinan.png') }}" class="h-full w-full object-cover transition-all duration-1000 group-hover:scale-105" alt="Karolog">
                    </div>
                    <div class="text-left px-4">
                        <span class="text-brand-primary font-black uppercase tracking-[0.4em] text-[10px] mb-3 block">KAROLOG POLDA NTB</span>
                        <h3 class="text-2xl font-black text-slate-800 italic uppercase font-outfit mb-4 leading-tight">
                            {!! nl2br(e($profile->name ?? 'KOMBES POL SAPTO PRIYONO')) !!}
                        </h3>

                        <div class="relative">
                            <svg class="absolute -top-3 -left-3 w-6 h-6 text-slate-200 opacity-50" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H13.017V21H14.017ZM6.017 21L6.017 18C6.017 16.8954 6.91243 16 8.017 16H11.017C11.5693 16 12.017 15.5523 12.017 15V9C12.017 8.44772 11.5693 8 11.017 8H8.017C7.46472 8 7.017 8.44772 7.017 9V12C7.017 12.5523 6.5693 13 6.017 13H5.017V21H6.017Z" /></svg>
                            <p class="text-slate-500 font-medium italic text-xs leading-relaxed pl-4">
                                "{{ $profile->quote ?? 'Logistik bukan hanya tentang pengadaan, tapi tentang memastikan setiap personel memiliki dukungan terbaik untuk menjaga keamanan masyarakat NTB. Kami berkomitmen pada transparansi dan modernisasi layanan di era digital ini.' }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Grid - Expanded -->
            <div class="lg:col-span-9 space-y-12 pt-6 reveal-on-scroll" style="transition-delay: 0.2s;">
                <div class="space-y-4">
                    <h2 class="text-5xl md:text-7xl font-black italic uppercase font-outfit tracking-tighter bg-gradient-to-r from-red-600 via-orange-500 via-yellow-500 via-amber-800 to-black bg-clip-text text-transparent leading-tight">
                        Layanan Digital
                    </h2>
                    <p class="text-slate-600 text-lg font-medium max-w-2xl leading-relaxed border-l-4 border-brand-primary pl-6">
                        {{ $profile->ecosystem_description ?? 'Biro Logistik Polda NTB menghadirkan layanan digital untuk mempermudah pendataan, pengajuan, monitoring, dan pelaporan logistik secara cepat, akurat, dan transparan.' }}
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    @forelse ($apps as $app)
                        <a href="{{ $app->url }}" target="_blank" class="service-tile p-5 hover-shine group overflow-hidden relative">
                            <div class="tile-icon relative z-10">
                                @if($app->icon)
                                    <img src="{{ asset('storage/' . $app->icon) }}" class="h-full w-full object-contain" alt="">
                                @else
                                    <svg class="h-10 w-10 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                @endif
                            </div>
                            <div class="flex-1 relative z-10 pr-4">
                                <h4 class="text-lg md:text-xl font-black text-slate-800 uppercase font-outfit leading-tight group-hover:text-white transition-colors mb-2">{{ $app->title }}</h4>
                                <p class="text-[10px] font-medium text-slate-500 leading-relaxed line-clamp-2 italic">
                                    {{ $app->description ?? 'Portal akses digital biro logistik polda ntb untuk mendukung efisiensi operasional.' }}
                                </p>
                            </div>
                            <!-- Arrow Indicator -->
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 group-hover:translate-x-2 transition-all">
                                <svg class="w-4 h-4 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full py-20 text-center border-2 border-dashed border-slate-200 rounded-[3rem] text-slate-400 font-black uppercase text-xs tracking-widest">No Active Digital Portals</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NEWS WALL: Instagram Style Feed -->
<section id="berita" class="pt-4 pb-32 bg-slate-50 px-8 reveal-on-scroll scroll-mt-32">
    <div class="max-w-[1440px] mx-auto">
        <div class="flex items-center justify-between gap-10 mb-12">
            <h2 class="text-3xl font-bold text-[#1e293b] font-jakarta tracking-tight">Berita Terbaru Biro Logistik</h2>
            <a href="#" class="text-sm font-semibold text-red-500 hover:text-red-700 transition-colors">Lihat semua</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($news as $item)
                <div class="news-card-elite group">
                    <!-- Instagram Header -->
                    <div class="ig-header">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-full border border-slate-100 overflow-hidden bg-slate-50 p-1">
                                <img src="{{ asset('log polri.png') }}" class="h-full w-full object-contain" alt="Logo">
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-black text-slate-800 tracking-tight">birologistik_ntb</span>
                                <span class="text-[10px] text-slate-400 font-medium tracking-tight">Polda NTB</span>
                            </div>
                        </div>
                        <a href="{{ route('portal.news.show', $item->slug) }}" class="px-4 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-[10px] font-black rounded-lg transition-colors">Detail</a>
                    </div>

                    <!-- Instagram Media -->
                    <a href="{{ route('portal.news.show', $item->slug) }}" class="block relative aspect-square overflow-hidden bg-slate-100 group-hover:brightness-95 transition-all">
                        @if($item->thumbnail)
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" class="h-full w-full object-cover" alt="{{ $item->title }}">
                        @else
                            <div class="h-full w-full flex items-center justify-center text-slate-300">
                                <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                    </a>

                    <!-- Instagram Content -->
                    <div class="p-4 space-y-4 flex-1 flex flex-col">
                        <div class="flex items-center gap-3">
                            <div class="ig-badge">BERITA</div>
                            <a href="https://www.instagram.com/birologistik_ntb/" target="_blank" class="h-6 w-6 rounded-lg bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] flex items-center justify-center shadow-sm hover:scale-110 transition-transform cursor-pointer">
                                <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.247 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.061 1.366-.333 2.633-1.308 3.608-.975.975-2.242 1.247-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.061-2.633-.333-3.608-1.308-.975-.975-1.247-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.061-1.366.333-2.633 1.308-3.608.975-.975 2.242-1.247 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.62.074-2.812.333-3.846 1.367-1.037 1.034-1.295 2.225-1.369 3.846-.058 1.28-.072 1.688-.072 4.947s.014 3.667.072 4.947c.074 1.621.332 2.812 1.369 3.846 1.034 1.037 2.225 1.295 3.846 1.369 1.28.058 1.688.072 4.947.072s3.667-.014 4.947-.072c1.621-.074 2.812-.332 3.846-1.369 1.037-1.034 1.295-2.225 1.369-3.846.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.074-1.621-.332-2.812-1.369-3.846-1.034-1.037-2.225-1.295-3.846-1.369-1.28-.058-1.688-.072-4.947-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="flex-1">
                            <h3 class="text-lg font-black text-slate-800 leading-tight mb-2 tracking-tight uppercase">
                                {{ $item->title }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ Str::limit(strip_tags($item->content), 100) }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-50">
                            <a href="{{ route('portal.news.show', $item->slug) }}" class="text-xs font-bold text-slate-400 hover:text-blue-500 transition-colors flex items-center justify-between">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ELITE DOKUMEN REPOSITORY -->
<section id="dokumen" class="pt-4 pb-32 bg-white px-8 relative overflow-hidden reveal-on-scroll scroll-mt-32">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-slate-50/50 -skew-x-12 translate-x-1/2"></div>
    <div class="max-w-[1440px] mx-auto relative z-10 w-full">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-8">
            <div class="space-y-2">
                <h2 class="text-3xl font-bold text-[#1e293b] font-jakarta tracking-tight">Dokumen</h2>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($folders as $folder)
            <div class="group relative bg-slate-50 rounded-[2rem] p-6 border border-slate-200 hover:border-brand-primary hover:bg-white hover:shadow-xl hover:shadow-brand-primary/5 transition-all duration-500 flex flex-col">
                <div class="flex items-start justify-between mb-4">
                    <div class="h-12 w-12 rounded-xl bg-white shadow-sm flex items-center justify-center text-amber-500 group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                    </div>
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400 group-hover:text-amber-600 transition-colors">
                        {{ $folder->documents->count() }} Berkas
                    </span>
                </div>

                <div class="mb-4 flex-grow">
                    <h3 class="text-sm font-black text-slate-900 font-outfit uppercase tracking-tight leading-tight group-hover:text-brand-primary transition-colors line-clamp-2 min-h-[2.5rem]">
                        {{ $folder->name }}
                    </h3>
                    @if($folder->description)
                    <p class="text-[10px] text-slate-500 font-medium leading-relaxed line-clamp-2 mt-1">
                        {{ $folder->description }}
                    </p>
                    @endif
                </div>

                <div class="space-y-3" x-data="{ open: false, selectedTitle: 'Pilih Berkas...' }">
                    <!-- Custom Premium Dropdown -->
                    <div class="relative">
                        <button @click="open = !open" @click.outside="open = false" 
                            type="button"
                            class="w-full flex items-center justify-between bg-white border border-slate-200 rounded-xl py-2.5 px-4 text-[9px] font-black uppercase tracking-widest text-slate-700 hover:border-brand-primary transition-all shadow-sm outline-none">
                            <span class="truncate pr-4" x-text="selectedTitle">Pilih Berkas...</span>
                            <svg class="w-3 h-3 text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" /></svg>
                        </button>
                        
                        <div x-show="open" 
                             x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                             class="absolute z-[100] w-full mt-2 bg-white border border-slate-100 rounded-2xl shadow-2xl shadow-brand-primary/10 py-2 max-h-48 overflow-y-auto outline-none pointer-events-auto">
                            @foreach($folder->documents as $doc)
                            <button type="button" @click="selectedTitle = '{{ $doc->title }}'; open = false; updateDownloadLinkManual('{{ asset('storage/' . $doc->file_path) }}', '{{ $folder->id }}')"
                                    class="w-full text-left px-4 py-2 text-[9px] font-bold uppercase tracking-widest text-slate-600 hover:bg-slate-50 hover:text-brand-primary transition-colors border-b border-slate-50 last:border-none">
                                {{ $doc->title }}
                            </button>
                            @endforeach
                            @if($folder->documents->isEmpty())
                            <div class="px-4 py-2 text-[9px] font-bold text-slate-400 italic">Kosong</div>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2 mt-auto">
                        <!-- Individual Download -->
                        <a id="download-{{ $folder->id }}" href="#" target="_blank"
                            class="flex items-center justify-center py-2.5 rounded-xl border text-[8px] font-black uppercase tracking-widest transition-all bg-slate-50 text-slate-300 border-slate-100 pointer-events-none">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        </a>
                        <!-- Folder ZIP Download -->
                        <a href="{{ route('portal.folders.download', $folder) }}" 
                            class="flex items-center justify-center py-2.5 bg-amber-500 text-white border border-amber-500 rounded-xl text-[8px] font-black uppercase tracking-widest hover:bg-amber-600 hover:scale-[1.02] active:scale-95 transition-all shadow-sm"
                            title="Download Semua (.ZIP)">
                            <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" /></svg>
                            ZIP
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Standalone Documents -->
            @foreach($standaloneDocuments as $doc)
            <div class="group relative bg-slate-50 rounded-[2rem] p-6 border border-slate-200 hover:border-brand-primary hover:bg-white hover:shadow-xl hover:shadow-brand-primary/5 transition-all duration-500 flex flex-col">
                <div class="flex items-start justify-between mb-4">
                    <div class="h-10 w-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-brand-primary group-hover:scale-110 group-hover:bg-brand-primary group-hover:text-white transition-all duration-500">
                        @if(in_array($doc->file_type, ['pdf']))
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        @else
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        @endif
                    </div>
                </div>

                <div class="mb-6 flex-grow">
                    <h3 class="text-sm font-black text-slate-900 font-outfit uppercase tracking-tight leading-tight group-hover:text-brand-primary transition-colors line-clamp-3">
                        {{ $doc->title }}
                    </h3>
                    <p class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mt-2">
                        {{ $doc->file_size }}
                    </p>
                </div>

                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="w-full inline-flex items-center justify-center gap-2 py-3 bg-white border border-slate-200 rounded-xl text-[9px] font-black uppercase tracking-widest text-slate-900 hover:bg-brand-primary hover:text-white hover:border-brand-primary hover:scale-[1.02] active:scale-95 transition-all shadow-sm">
                    Unduh
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                </a>
            </div>
            @endforeach

            @if($folders->count() === 0 && $standaloneDocuments->count() === 0)
            <div class="col-span-full py-20 bg-slate-50 rounded-[3rem] border border-dashed border-slate-200 flex flex-col items-center justify-center text-center px-8">
                 <div class="h-20 w-20 bg-white rounded-3xl shadow-sm flex items-center justify-center text-slate-300 mb-6">
                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                 </div>
                 <h4 class="text-lg font-black text-slate-400 uppercase tracking-widest italic font-outfit">Arsip Belum Tersedia</h4>
                 <p class="text-sm text-slate-400 mt-2 font-bold italic uppercase tracking-widest">Dokumen publik akan segera diunggah oleh admin.</p>
            </div>
            @endif
        </div>
    </div>
</section>

<script>
    function updateDownloadLinkManual(url, folderId) {
        const btn = document.getElementById('download-' + folderId);
        
        if (url) {
            btn.href = url;
            btn.classList.remove('bg-slate-50', 'text-slate-300', 'border-slate-100', 'pointer-events-none');
            btn.classList.add('bg-brand-primary', 'text-white', 'border-brand-primary', 'hover:scale-[1.02]', 'active:scale-95');
        } else {
            btn.href = '#';
            btn.classList.add('bg-slate-50', 'text-slate-300', 'border-slate-100', 'pointer-events-none');
            btn.classList.remove('bg-brand-primary', 'text-white', 'border-brand-primary', 'hover:scale-[1.02]', 'active:scale-95');
        }
    }
</script>

<!-- ELITE STRUKTUR: COMMAND -->
<section id="struktur" class="pt-4 pb-44 bg-slate-50 px-8 relative overflow-hidden reveal-on-scroll scroll-mt-32">
    <div class="absolute -bottom-1/4 -right-1/4 w-[800px] h-[800px] bg-brand-primary/10 blur-[150px] rounded-full point-events-none"></div>
    <div class="max-w-[1440px] mx-auto relative z-10 w-full">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-8">
            <div class="space-y-4">
                <h2 class="text-2xl md:text-3xl font-black italic uppercase font-outfit tracking-[0.3em] bg-gradient-to-r from-red-600 via-orange-500 via-yellow-500 via-amber-800 to-black bg-clip-text text-transparent leading-none">
                    Struktur Organisasi
                </h2>
                <div class="h-1.5 w-64 bg-brand-primary rounded-full"></div>
            </div>
        </div>

        <div class="w-full">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-x-2 gap-y-12">
                @php
                    // Meratakan pohon menjadi list (opsional, atau bisa tampilkan root saja tergantung keinginan user)
                    // Untuk sementara kita tampilkan semua personil secara flat agar rapi tanpa bagan.
                    $allPersonnels = \App\Models\Organogram::orderBy('order')->get();
                @endphp
                
                @foreach($allPersonnels as $person)
                    <div class="reveal-on-scroll">
                        @include('components.org-card', ['node' => $person])
                    </div>
                @endforeach

                @if($allPersonnels->isEmpty())
                    <div class="col-span-full py-20 bg-slate-50 rounded-[3rem] border border-dashed border-slate-200 flex flex-col items-center justify-center text-center px-8">
                         <div class="h-20 w-20 bg-white rounded-3xl shadow-sm flex items-center justify-center text-slate-300 mb-6">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                         </div>
                         <h4 class="text-sm font-black text-slate-400 uppercase tracking-widest italic">Data Personil Belum Diinput</h4>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Instagram Modal -->
<div id="instaModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4">
    <div onclick="closeInstaModal()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>
    <div class="relative bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden animate-in zoom-in duration-300">
        <button onclick="closeInstaModal()" class="absolute top-6 right-6 z-20 h-10 w-10 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500 transition-colors shadow-sm">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        <div id="instaContainer" class="aspect-[4/5] w-full bg-slate-50 flex items-center justify-center">
            <div class="flex flex-col items-center gap-4 text-slate-400">
                <svg class="h-12 w-12 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span class="text-xs font-black uppercase tracking-widest">Memuat Konten...</span>
            </div>
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
        const regex = /(?:p|reels|tv)\/([^\/?#&]+)/;
        const match = url.match(regex);
        const shortcode = match ? match[1] : null;
        if (shortcode) {
            container.innerHTML = `<iframe class="w-full h-full border-none" src="https://www.instagram.com/p/${shortcode}/embed" frameborder="0" scrolling="no" allowtransparency="true"></iframe>`;
        } else {
            container.innerHTML = `<div class="p-12 text-center"><p class="text-slate-500 font-bold">Link Instagram tidak valid.</p></div>`;
        }
    }

    function closeInstaModal() {
        const modal = document.getElementById('instaModal');
        const container = document.getElementById('instaContainer');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        container.innerHTML = `<div class="flex flex-col items-center gap-4 text-slate-400"><svg class="h-12 w-12 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="text-xs font-black uppercase tracking-widest">Memuat Konten...</span></div>`;
    }

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeInstaModal();
    });
</script>
@endsection
