@extends('layout')

@section('title', $news->title)

@section('content')
<div class="max-w-4xl mx-auto py-4 md:py-12 px-4 md:px-8">
    <!-- Breadcrumbs -->
    <nav class="hidden md:flex mb-8 text-xs font-black uppercase tracking-widest text-slate-400 gap-2 items-center" aria-label="Breadcrumb">
        <a href="{{ route('portal.index') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
        <a href="{{ route('portal.index') }}#berita" class="hover:text-indigo-600 transition-colors">Berita</a>
        <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" /></svg>
        <span class="text-slate-900">Detail Artikel</span>
    </nav>

    <article class="bg-white rounded-[3rem] shadow-2xl shadow-indigo-100/50 border border-white overflow-hidden">
        <!-- Hero Section with Improved Image Handling -->
        <div class="relative bg-slate-50 border-b border-gray-50 flex items-center justify-center overflow-hidden min-h-[300px] md:min-h-[500px]">
            @if($news->thumbnail)
                <img src="{{ asset('storage/' . $news->thumbnail) }}" class="max-w-full max-h-[70vh] object-contain drop-shadow-2xl" alt="{{ $news->title }}">
                
                <!-- Blurred Background for Pillar-boxing effect -->
                <div class="absolute inset-0 -z-10 opacity-20 blur-3xl scale-110">
                    <img src="{{ asset('storage/' . $news->thumbnail) }}" class="h-full w-full object-cover" alt="">
                </div>
            @else
                <div class="h-64 w-full bg-indigo-50 flex items-center justify-center text-indigo-200">
                    <svg class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                </div>
            @endif
            
        </div>

        <div class="p-5 md:p-16">
            <!-- Header -->
            <header class="mb-8 md:mb-12">
                <div class="flex flex-wrap gap-2 md:gap-3 mb-6 md:mb-8">
                    <span class="inline-flex items-center px-3 py-1.5 md:px-4 md:py-2 bg-indigo-600 text-white rounded-lg md:rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-widest shadow-lg shadow-indigo-100">
                        BERITA TERKINI
                    </span>
                    <span class="inline-flex items-center px-3 py-1.5 md:px-4 md:py-2 bg-slate-100 rounded-lg md:rounded-xl text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-600">
                        {{ $news->created_at->format('d F Y') }}
                    </span>
                </div>

                <h1 class="text-3xl md:text-5xl font-black text-slate-900 leading-tight uppercase italic mb-6 md:mb-8 tracking-tight">
                    {{ $news->title }}
                </h1>
                
                <div class="flex flex-wrap items-center gap-4 md:gap-6 pb-6 md:pb-8 border-b border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 md:h-12 md:w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-black text-xs md:text-sm">
                            {{ substr($news->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="text-left">
                            <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-slate-400 leading-none mb-1">Penulis</p>
                            <p class="text-[11px] md:text-xs font-bold text-slate-900 uppercase tracking-tighter">{{ $news->user->name ?? 'Administrator' }}</p>
                        </div>
                    </div>

                    @if($news->instagram_url)
                        <div class="h-8 w-px bg-gray-100"></div>
                        <button onclick="openInstaModal('{{ $news->instagram_url }}')" class="flex items-center gap-3 group text-left">
                            <div class="h-10 w-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center group-hover:bg-rose-600 group-hover:text-white transition-all shadow-sm shadow-rose-100">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </div>
                            <div class="text-left">
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 leading-none mb-1">Instagram</p>
                                <p class="text-xs font-bold text-rose-600 uppercase tracking-tighter group-hover:text-rose-700 transition-colors">Tonton di Sini</p>
                            </div>
                        </button>
                    @endif
                </div>
            </header>

            <!-- Content Area - Forced Dark Text for Readability -->
            <div class="text-slate-900">
                <div class="prose prose-slate max-w-none prose-p:text-slate-900 prose-p:font-bold prose-p:leading-relaxed prose-p:text-lg prose-p:mb-8 prose-headings:text-slate-900 prose-headings:font-black prose-headings:uppercase prose-headings:italic">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </div>

            <!-- Footer Meta -->
            <footer class="mt-16 pt-8 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-4">
                     <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Bagikan:</span>
                     <div class="flex gap-2">
                         <button class="h-10 w-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-black hover:text-white transition-all"><svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg></button>
                         <button class="h-10 w-10 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.319 1.592 5.548 0 10.058-4.51 10.06-10.059.002-2.689-1.047-5.215-2.951-7.119-1.906-1.905-4.432-2.956-7.124-2.957-5.549 0-10.06 4.511-10.063 10.06-.001 2.126.588 4.197 1.699 5.86l-.999 3.648 3.744-.982zm11.367-7.854c-.327-.164-1.938-.957-2.239-1.066-.301-.11-.52-.164-.739.164-.219.328-.847 1.066-1.039 1.284-.191.219-.382.246-.709.082-.328-.164-1.383-.51-2.635-1.627-.973-.868-1.629-1.942-1.82-2.27-.191-.328-.021-.506.143-.668.147-.146.328-.383.491-.575.164-.191.219-.328.328-.547.11-.219.055-.41-.027-.575-.082-.164-.739-1.777-1.011-2.434-.266-.643-.532-.553-.739-.564l-.629-.01c-.219 0-.573.082-.874.41-.301.328-1.147 1.12-1.147 2.733s1.175 3.169 1.339 3.388c.164.219 2.31 3.528 5.596 4.945.783.336 1.393.537 1.868.688.788.249 1.504.214 2.071.129.632-.095 1.938-.792 2.212-1.558.274-.766.274-1.422.191-1.558-.083-.136-.301-.219-.628-.383z"/></svg></button>
                     </div>
                </div>

                <a href="{{ route('portal.index') }}#berita" class="px-8 py-4 bg-slate-900 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-indigo-600 transition-all flex items-center gap-3 active:scale-95">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                    Lihat Berita Lainnya
                </a>
            </footer>
        </div>
    </article>
</div>

<!-- Instagram Modal -->
<div id="instaModal" class="fixed inset-0 z-[100] hidden items-center justify-center md:p-4">
    <!-- Backdrop -->
    <div onclick="closeInstaModal()" class="absolute inset-0 bg-slate-950/100 md:bg-slate-950/80 backdrop-blur-sm"></div>
    
    <!-- Modal Content -->
    <div class="relative bg-white w-full h-full md:h-auto md:max-w-lg md:rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col animate-in zoom-in duration-300">
        <button onclick="closeInstaModal()" class="absolute top-4 right-4 md:top-6 md:right-6 z-20 h-10 w-10 md:h-10 md:w-10 rounded-full bg-white/50 backdrop-blur-md md:bg-white/10 hover:bg-slate-100 flex items-center justify-center text-slate-700 md:text-slate-500 transition-colors shadow-lg border border-black/10 md:border-gray-100">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
        
        <div id="instaContainer" class="flex-1 w-full md:aspect-[4/5] bg-slate-50 flex items-center justify-center">
            <div class="flex flex-col items-center gap-4 text-slate-300">
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
        
        // Show modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
        
        // Extract shortcode
        const regex = /(?:p|reels|tv)\/([^\/?#&]+)/;
        const match = url.match(regex);
        const shortcode = match ? match[1] : null;
        
        if (shortcode) {
            container.innerHTML = `
                <iframe 
                    class="w-full h-full border-none shadow-none"
                    src="https://www.instagram.com/p/${shortcode}/embed" 
                    frameborder="0" 
                    scrolling="no" 
                    allowtransparency="true">
                </iframe>`;
        } else {
            container.innerHTML = `
                <div class="p-12 text-center">
                    <p class="text-slate-400 font-bold">Link Instagram tidak valid.</p>
                </div>`;
        }
    }

    function closeInstaModal() {
        const modal = document.getElementById('instaModal');
        const container = document.getElementById('instaContainer');
        
        // Hide modal
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
        
        // Reset container
        container.innerHTML = `
            <div class="flex flex-col items-center gap-4 text-slate-300">
                <svg class="h-12 w-12 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <span class="text-xs font-black uppercase tracking-widest">Memuat Konten...</span>
            </div>`;
    }

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeInstaModal();
    });
</script>
@endsection
