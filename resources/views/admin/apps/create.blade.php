@extends('admin.layout')

@section('title', 'Tambah Aplikasi')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-slate-900/50 backdrop-blur-2xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
        <div class="bg-slate-900 px-10 py-8 flex justify-between items-center border-b border-white/5">
            <h2 class="text-white font-black tracking-tight font-outfit uppercase italic">Registrasi Aset Digital</h2>
            <a href="{{ route('admin.apps.index') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-500 hover:text-white transition-colors flex items-center gap-3 italic">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Abort Protocol
            </a>
        </div>

        <form action="{{ route('admin.apps.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-3">
                    <label for="title" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Service Label</label>
                    <input id="title" name="title" type="text" value="{{ old('title') }}" required autofocus
                        class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                        placeholder="Contoh: HRIS Portal">
                    @error('title') <p class="text-[10px] text-rose-500 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3">
                    <label for="category" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Deployment Category</label>
                    <input id="category" name="category" type="text" value="{{ old('category') }}"
                        class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                        placeholder="Contoh: Internal, Layanan Umum">
                    @error('category') <p class="text-[10px] text-rose-500 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="space-y-3">
                <label for="url" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Endpoint Access (URL)</label>
                <input id="url" name="url" type="url" value="{{ old('url') }}" required
                    class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                    placeholder="https://aplikasi.perusahaan.com">
                @error('url') <p class="text-[10px] text-rose-500 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-4">
                <label for="icon" class="text-[10px] font-black uppercase tracking-widest text-slate-500 block">Visual Identity (Icon)</label>
                <div class="flex items-center gap-8">
                    <div id="icon-preview-container" class="hidden shrink-0 h-24 w-24 bg-white rounded-2xl overflow-hidden border border-white/10 shadow-2xl flex items-center justify-center p-3">
                        <img id="icon-preview" src="#" alt="Preview" class="h-full w-full object-contain" />
                    </div>
                    <div class="flex-1">
                        <label class="cursor-pointer bg-slate-800/50 hover:bg-brand-primary/20 text-slate-300 hover:text-white font-black py-4 px-8 rounded-2xl border-2 border-dashed border-white/10 transition-all inline-block">
                            <span class="text-[10px] uppercase tracking-widest">Upload Master Icon</span>
                            <input type="file" id="icon" name="icon" accept="image/*" onchange="previewIcon(event)" class="sr-only"/>
                        </label>
                        <p class="text-[9px] text-slate-500 mt-3 uppercase font-black tracking-widest">Format: PNG Transparent Recommended</p>
                    </div>
                </div>
                @error('icon') <p class="text-[10px] text-rose-500 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-3">
                <label for="description" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Strategic Overview (Description)</label>
                <textarea id="description" name="description" rows="4"
                    class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold italic transition-all placeholder:text-slate-600"
                    placeholder="Jelaskan kegunaan aplikasi ini dalam 1-2 kalimat...">{{ old('description') }}</textarea>
                @error('description') <p class="text-[10px] text-rose-500 font-bold uppercase tracking-widest">{{ $message }}</p> @enderror
            </div>

            <div class="pt-10 border-t border-white/5 flex justify-end">
                <button type="submit" class="bg-brand-primary text-white px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-primary/40 hover:scale-105 transition-all active:scale-[0.98] italic">
                    Execute Registration
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewIcon(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('icon-preview');
            const container = document.getElementById('icon-preview-container');
            output.src = reader.result;
            container.classList.remove('hidden');
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
