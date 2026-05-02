@extends('layout')

@section('title', 'Arsip Berita - Biro Logistik Polda NTB')

@section('content')
<div class="bg-[#0f172a] min-h-screen pt-12 pb-24 px-6 md:px-8 relative overflow-hidden">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-amber-500/5 -skew-x-12 translate-x-1/4 -translate-y-1/4"></div>
    <div class="absolute bottom-0 left-0 w-1/2 h-1/2 bg-red-600/5 skew-x-12 -translate-x-1/4 translate-y-1/4"></div>

    <div class="max-w-[1200px] mx-auto relative z-10">
        <!-- Header -->
        <div class="mb-16">
            <nav class="flex mb-8 text-[9px] font-black uppercase tracking-[0.3em] text-slate-500 gap-3 items-center" aria-label="Breadcrumb">
                <a href="{{ route('portal.index') }}" class="hover:text-amber-500 transition-colors">Beranda</a>
                <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
                <span class="text-white">Arsip Berita</span>
            </nav>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="h-[2px] w-6 bg-amber-500 rounded-full shadow-[0_0_8px_rgba(245,158,11,0.6)]"></div>
                        <span class="text-amber-500 font-black uppercase tracking-[0.4em] text-[10px]">Polda NTB Updates</span>
                    </div>
                    <h1 class="text-xl md:text-6xl font-black text-white uppercase font-outfit leading-none italic">Seluruh Berita</h1>
                </div>
            </div>
        </div>

        <!-- News Grid/List -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-16">
            @forelse($news as $item)
                <div class="group relative">
                    <a href="{{ route('portal.news.show', $item->slug) }}" class="bg-slate-800/40 backdrop-blur-md p-4 md:p-6 rounded-[2.5rem] flex items-center gap-5 md:gap-8 border border-white/5 transition-all duration-500 transform hover:scale-[1.02] hover:-translate-y-1 hover:shadow-[0_25px_50px_rgba(0,0,0,0.5)] hover:border-amber-500/30 hover:bg-slate-800 active:scale-95 block h-full overflow-hidden">
                        <!-- Thumbnail -->
                        <div class="w-24 h-24 md:w-36 md:h-36 shrink-0 rounded-[2rem] overflow-hidden shadow-2xl relative group-hover:rotate-2 transition-transform duration-500">
                            @if($item->thumbnail)
                                <img src="{{ asset('storage/' . $item->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $item->title }}">
                            @else
                                <div class="w-full h-full bg-slate-900 flex items-center justify-center text-slate-700">
                                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-tr from-amber-500/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 flex flex-col justify-center overflow-hidden">
                            <div class="flex items-center gap-3 mb-2 md:mb-4">
                                <span class="text-[8px] md:text-[9px] font-black text-amber-500 uppercase tracking-widest">{{ $item->created_at->format('d M Y') }}</span>
                                <div class="h-1 w-1 bg-white/20 rounded-full"></div>
                                <span class="text-[8px] md:text-[9px] font-bold text-slate-500 uppercase tracking-tighter">{{ $item->user->name ?? 'Admin' }}</span>
                            </div>
                            
                            <h4 class="text-xs md:text-xl font-black text-white uppercase leading-tight md:leading-snug line-clamp-2 md:line-clamp-3 font-outfit group-hover:text-amber-500 transition-colors mb-4">{{ $item->title }}</h4>
                            
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2 text-amber-500 group-hover:gap-3 transition-all">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    <span class="text-[9px] md:text-[10px] font-black uppercase tracking-widest">Baca Berita</span>
                                </div>

                                @if($item->instagram_url)
                                    <button onclick="event.preventDefault(); openInstaModal('{{ $item->instagram_url }}')" class="h-8 md:h-10 px-3 md:px-4 rounded-xl bg-rose-500/10 text-rose-500 border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all flex items-center gap-2 relative z-20">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.332 3.608 1.308.975.975 1.247 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.061 1.366-.333 2.633-1.308 3.608-.975.975-2.242 1.247-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.061-2.633-.333-3.608-1.308-.975-.975-1.247-2.242-1.308-3.608-.058-1.266-.07-1.646-.07-4.85s.012-3.584.07-4.85c.061-1.366.333-2.633 1.308-3.608.975-.975 2.242-1.247 3.608-1.308 1.266-.058 1.646-.07 4.85-.07zm0-2.163c-3.259 0-3.667.014-4.947.072-1.62.074-2.812.333-3.846 1.367-1.037 1.034-1.295 2.225-1.369 3.846-.058 1.28-.072 1.688-.072 4.947s.014 3.667.072 4.947c.074 1.621.332 2.812 1.369 3.846 1.034 1.037 2.225 1.295 3.846 1.369 1.28.058 1.688.072 4.947.072s3.667-.014 4.947-.072c1.621-.074 2.812-.332 3.846-1.369 1.037-1.034 1.295-2.225 1.369-3.846.058-1.28.072-1.688.072-4.947s-.014-3.667-.072-4.947c-.074-1.621-.332-2.812-1.369-3.846-1.034-1.037-2.225-1.295-3.846-1.369-1.28-.058-1.688-.072-4.947-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.162 6.162 6.162 6.162-2.759 6.162-6.162-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        <span class="text-[9px] font-black uppercase">Instagram</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-span-full py-32 text-center bg-slate-800/20 rounded-[3rem] border border-white/5">
                    <div class="w-20 h-20 bg-slate-900 rounded-full flex items-center justify-center text-slate-700 mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 3v5h5" /></svg>
                    </div>
                    <p class="text-slate-500 font-black uppercase tracking-widest text-[10px]">Belum ada berita yang diterbitkan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12 flex justify-center custom-pagination">
            {{ $news->links() }}
        </div>
    </div>
</div>

<!-- Instagram Modal -->
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
            container.innerHTML = `<iframe class="w-full h-full border-none shadow-none" src="https://www.instagram.com/p/${shortcode}/embed" frameborder="0" scrolling="no" allowtransparency="true"></iframe>`;
        }
    }
    function closeInstaModal() {
        const modal = document.getElementById('instaModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    }
</script>

<style>
    .custom-pagination nav > div:first-child { display: none; }
    .custom-pagination nav span, .custom-pagination nav a {
        background: #1e293b !important;
        border-color: rgba(255,255,255,0.05) !important;
        color: #94a3b8 !important;
        border-radius: 1rem !important;
        padding: 0.75rem 1.25rem !important;
        font-weight: 900 !important;
        text-transform: uppercase !important;
        font-size: 10px !important;
        letter-spacing: 0.1em !important;
    }
    .custom-pagination nav span[aria-current="page"] {
        background: #f59e0b !important;
        color: #0f172a !important;
        box-shadow: 0 0 15px rgba(245,158,11,0.3) !important;
    }
</style>
@endsection
