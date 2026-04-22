@extends('admin.layout')

@section('title', 'Tambah Berita')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-slate-900/50 backdrop-blur-2xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
        <div class="bg-slate-900 px-10 py-8 flex justify-between items-center border-b border-white/5">
            <h2 class="text-white font-black tracking-tight font-outfit uppercase italic">Komposisi Narasi Baru</h2>
            <a href="{{ route('admin.news.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors flex items-center gap-3 italic">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Abort Protocol
            </a>
        </div>

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            
            <div class="space-y-3">
                <label for="title" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Narrative Title / Headline</label>
                <input id="title" name="title" type="text" value="{{ old('title') }}" required autofocus
                    class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-xl font-black italic transition-all placeholder:text-slate-600 font-outfit uppercase"
                    placeholder="Masukkan Headline Strategis...">
                @error('title') <p class="text-[10px] text-rose-500 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-4">
                <label for="thumbnail" class="text-[10px] font-black uppercase tracking-widest text-slate-500 block">Visual Assets (Thumbnail)</label>
                
                <div class="flex flex-col sm:flex-row items-center gap-8">
                    <div id="preview-container" class="hidden shrink-0 h-44 w-72 bg-slate-800 rounded-2xl overflow-hidden border border-white/10 shadow-2xl flex items-center justify-center p-2 relative group">
                        <img id="image-preview" src="#" alt="Preview" class="h-full w-full object-cover rounded-xl" />
                    </div>
                    
                    <div class="flex-1 w-full">
                        <label class="relative cursor-pointer bg-slate-800/50 hover:bg-brand-primary/20 text-slate-300 hover:text-white font-black py-10 rounded-2xl border-2 border-dashed border-white/10 transition-all flex flex-col items-center justify-center group overflow-hidden">
                            <svg class="h-12 w-12 mb-3 text-slate-600 group-hover:text-brand-primary transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-[10px] uppercase tracking-widest">Select Narrative Thumbnail</span>
                            <span class="text-[8px] text-slate-500 mt-2 uppercase font-black">JPG, PNG, WEBP (Max 2MB)</span>
                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="sr-only" onchange="previewImage(event)"/>
                        </label>
                    </div>
                </div>
                @error('thumbnail') <p class="text-[10px] text-rose-500 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-3">
                <label for="instagram_url" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Instagram Protocol Sync (Optional)</label>
                <div class="relative group">
                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-rose-500 group-focus-within:rotate-12 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                    </div>
                    <input id="instagram_url" name="instagram_url" type="url" value="{{ old('instagram_url') }}"
                        class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 pl-14 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                        placeholder="https://www.instagram.com/reels/...">
                </div>
                @error('instagram_url') <p class="text-[10px] text-rose-500 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-3">
                <label for="content" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Narrative Substance (Content)</label>
                <textarea id="content" name="content" rows="12" required
                    class="block w-full bg-slate-800/50 rounded-[2rem] border-white/5 py-8 px-10 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-lg font-medium leading-relaxed transition-all placeholder:text-slate-600"
                    placeholder="Tuliskan substansi narasi lengkap di sini...">{{ old('content') }}</textarea>
                @error('content') <p class="text-[10px] text-rose-500 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
            </div>

            <div class="pt-10 border-t border-white/5 flex justify-end">
                <button type="submit" class="bg-brand-primary text-white px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-primary/40 hover:scale-105 transition-all active:scale-[0.98] italic">
                    Execute Publication
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('image-preview');
            const container = document.getElementById('preview-container');
            output.src = reader.result;
            container.classList.remove('hidden');
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
