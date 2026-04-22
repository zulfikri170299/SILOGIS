@extends('layout')

@section('content')
<!-- Custom Modern CSS -->
<style>
    /* SILOGIS - Modern Light & High Contrast */
    .font-outfit { font-family: 'Outfit', sans-serif; }
    
    .elite-hero {
        position: relative;
        background: url('{{ asset('hero_bg.png') }}') no-repeat center center;
        background-size: cover;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 100px;
    }

    .elite-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 1));
    }

    .grand-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(40px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 4rem;
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
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 1.25rem;
        transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0.75rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .service-tile:hover {
        background: #0062ff;
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 98, 255, 0.3);
        border-color: #0062ff;
    }

    .service-tile:hover h4, .service-tile:hover span {
        color: white;
    }

    .tile-icon {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s ease;
        padding: 8px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.02);
    }

    .service-tile:hover .tile-icon {
        background: white;
        color: #0062ff;
        transform: scale(1.1);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .news-card-elite {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 3rem;
        transition: all 0.5s ease;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
    }

    .news-card-elite:hover {
        border-color: #0062ff;
        transform: scale(1.02);
        box-shadow: 0 20px 50px rgba(0, 98, 255, 0.15);
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
</style>


<!-- ELITE HUB: Leader & Ecosystem -->
<section id="layanan" class="py-40 bg-slate-50 px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-start">
            <!-- Pimpinan Card - Compact Scale -->
            <div class="lg:col-span-4 relative group">
                <div class="absolute -inset-10 bg-brand-primary/10 blur-[80px] rounded-full opacity-60"></div>
                <div class="relative bg-white/80 backdrop-blur-2xl border border-slate-200 shadow-2xl rounded-[2.5rem] p-5 overflow-hidden">
                    <div class="aspect-[4/4.2] w-full rounded-[1.5rem] overflow-hidden mb-4 border-4 border-slate-100 shadow-sm mx-auto">
                         <img src="{{ $profile->photo ? (str_contains($profile->photo, 'pimpinan.png') ? asset($profile->photo) : asset('storage/' . $profile->photo)) : asset('pimpinan.png') }}" class="h-full w-full object-cover transition-all duration-1000 group-hover:scale-105" alt="Karolog">
                    </div>
                    <div class="text-center md:text-left px-2">
                        <span class="text-brand-primary font-black uppercase tracking-[0.4em] text-[10px] mb-1 block">KAROLOG POLDA NTB</span>
                        <h3 class="text-lg font-black text-slate-800 italic uppercase font-outfit mb-2 leading-tight">{!! nl2br(e($profile->name ?? 'Kombes Pol. Puji Prayitno, S.I.K., M.H.')) !!}</h3>
                        <p class="text-slate-600 font-bold italic text-[10px] leading-snug border-l-2 border-brand-primary pl-3">
                            "{{ $profile->quote ?? 'Inovasi logistik adalah fondasi dari kesuksesan operasional kepolisian modern.' }}"
                        </p>
                    </div>
                </div>
            </div>

            <!-- Services Grid - Expanded -->
            <div class="lg:col-span-8 space-y-12 pt-6">
                <div class="space-y-4">
                    <h2 class="text-3xl font-black text-slate-900 italic uppercase leading-[1.1] font-outfit tracking-tighter">Layanan <span class="text-brand-primary">Digital.</span></h2>
                    <p class="text-slate-600 text-lg font-medium max-w-xl leading-relaxed">{{ $profile->ecosystem_description ?? 'Akses cepat ke seluruh ekosistem digital biro logistik polda ntb dalam satu ubin kendali.' }}</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                    @forelse ($apps as $app)
                        <a href="{{ $app->url }}" target="_blank" class="service-tile p-4 hover-shine group overflow-hidden">
                            <div class="tile-icon shadow-sm relative z-10">
                                @if($app->icon)
                                    <img src="{{ asset('storage/' . $app->icon) }}" class="h-full w-full object-contain" alt="">
                                @else
                                    <svg class="h-8 w-8 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                                @endif
                            </div>
                            <div class="w-full relative z-10">
                                <h4 class="text-[11px] font-black text-slate-800 uppercase italic font-outfit leading-tight group-hover:scale-105 transition-transform truncate">{{ $app->title }}</h4>
                                <span class="text-[6px] font-black text-slate-500 uppercase tracking-widest italic transition-colors">Digital Portal</span>
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

<!-- NEWS WALL: High Contrast Library -->
<section id="berita" class="py-24 bg-white px-8">
    <div class="max-w-7xl mx-auto border-t border-slate-100 pt-16">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-10 mb-16">
            <div class="space-y-4">
                <h2 class="text-4xl font-black text-slate-900 italic uppercase font-outfit tracking-tighter">Berita <span class="text-brand-primary">Logistik.</span></h2>
            </div>
            <a href="#" class="px-8 py-4 bg-brand-primary text-white rounded-lg font-black uppercase tracking-widest text-[10px] hover:bg-brand-dark hover:text-white transition-all shadow-lg shadow-brand-primary/20 italic">Lihat Semua &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
            @foreach ($news as $item)
                <div class="news-card-elite group overflow-hidden">
                    <a href="{{ route('portal.news.show', $item->slug) }}" class="block p-3">
                        <div class="rounded-[2rem] overflow-hidden aspect-video mb-4 relative shadow-inner">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="h-full w-full object-cover group-hover:scale-110 transition-transform duration-1000" alt="{{ $item->title }}">
                            @else
                                <div class="h-full w-full bg-slate-100 flex items-center justify-center text-slate-400">
                                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                        </div>
                        <div class="px-2 pb-2 space-y-3">
                            <span class="text-[8px] font-black text-brand-primary uppercase tracking-[0.2em] block">{{ $item->created_at->format('M d, Y') }}</span>
                            <h3 class="text-sm font-black text-slate-800 group-hover:text-brand-primary transition-colors italic uppercase leading-tight font-outfit line-clamp-2 h-10">{{ $item->title }}</h3>
                            <p class="text-[10px] font-medium text-slate-500 line-clamp-3 leading-relaxed h-12">
                                {{ Str::limit(strip_tags($item->content), 60) }}
                            </p>
                            <div class="pt-3 mt-1 border-t border-slate-100 flex justify-between items-center text-[8px] font-black uppercase tracking-widest text-slate-400">
                                <span class="group-hover:text-brand-primary transition-colors">Selengkapnya &rarr;</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ELITE STRUKTUR: COMMAND -->
<section id="struktur" class="py-40 bg-slate-50 px-8 relative overflow-hidden">
    <div class="absolute -bottom-1/4 -right-1/4 w-[800px] h-[800px] bg-brand-primary/10 blur-[150px] rounded-full point-events-none"></div>
    <div class="max-w-7xl mx-auto flex flex-col items-center relative z-10 w-full">
        <div class="text-center mb-20 space-y-6">
            <span class="text-brand-primary font-black uppercase tracking-[0.5em] text-[10px] block">Institutional Core</span>
            <h2 class="text-4xl font-black text-slate-900 italic uppercase font-outfit tracking-tighter">Alur Komando <br> <span class="text-brand-primary italic">Presisi Digital.</span></h2>
            <div class="h-1 w-40 bg-brand-primary mx-auto rounded-full"></div>
        </div>

        <div class="w-full overflow-x-auto pb-10 custom-scrollbar flex justify-center">
             @include('components.exact-org-chart')
        </div>
        
        <style>
            .custom-scrollbar::-webkit-scrollbar { height: 8px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: rgba(0,0,0,0.02); border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(0,98,255,0.2); border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(0,98,255,0.4); }
        </style>
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
