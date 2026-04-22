@extends('admin.layout')

@section('title', 'Buat Folder Baru')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="space-y-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.document-folders.index') }}" class="h-12 w-12 rounded-2xl bg-slate-900 border border-white/5 flex items-center justify-center text-slate-400 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-black text-white italic tracking-tight font-outfit uppercase">Buat Folder</h2>
                <p class="text-slate-400 text-sm font-medium uppercase tracking-widest mt-1">Siapkan wadah baru untuk pengelolaan berkas</p>
            </div>
        </div>

        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
            <form action="{{ route('admin.document-folders.store') }}" method="POST" class="p-8 md:p-12 space-y-10">
                @csrf
                
                <div class="space-y-3">
                    <label for="name" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 flex items-center gap-2">
                         NAMA FOLDER
                         <span class="text-red-500">*</span>
                    </label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                        class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 px-6 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                        placeholder="Contoh: Dokumen Penghapusan">
                    @error('name') <p class="text-xs text-rose-500 font-bold mt-2">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-3">
                    <label for="description" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">DESKRIPSI FOLDER (OPSIONAL)</label>
                    <textarea id="description" name="description" rows="4" 
                        class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 px-6 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold italic transition-all placeholder:text-slate-600"
                        placeholder="Berikan sedikit penjelasan mengenai kelompok dokumen ini...">{{ old('description') }}</textarea>
                </div>

                <div class="pt-6 border-t border-white/5 flex justify-end">
                    <button type="submit" class="bg-brand-primary text-white px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-primary/40 hover:scale-105 transition-all active:scale-[0.98] italic">
                        Bangun Folder Digital
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
