@extends('admin.layout')

@section('title', 'Tambah Inputan ' . $bagian->name)

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.satker_inputs.index', $bagian->id) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-white transition-colors mb-4">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Data Inputan
    </a>
    <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight">Tambah Inputan</h2>
    <p class="text-sm text-slate-400 mt-1">Kirimkan hasil inputan Satker ke {{ $bagian->name }}.</p>
</div>

<div class="max-w-2xl bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl p-8">
    <form action="{{ route('admin.satker_inputs.store', $bagian->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="judul" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Judul Inputan</label>
            <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required
                class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all">
            @error('judul')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="deskripsi" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Deskripsi / Keterangan (Opsional)</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">File Lampiran (Opsional)</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-white/10 border-dashed rounded-2xl hover:border-brand-primary/50 transition-colors group">
                <div class="space-y-2 text-center">
                    <svg class="mx-auto h-12 w-12 text-slate-500 group-hover:text-brand-primary transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-slate-400 justify-center">
                        <label for="file_lampiran" class="relative cursor-pointer bg-slate-800 rounded-md font-medium text-brand-primary hover:text-indigo-400 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-brand-primary px-3 py-1">
                            <span>Pilih file</span>
                            <input id="file_lampiran" name="file_lampiran" type="file" class="sr-only">
                        </label>
                    </div>
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest">PDF, DOC, XLS, ZIP, JPEG, PNG hingga 10MB</p>
                </div>
            </div>
            @error('file_lampiran')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-white/5 flex justify-end">
            <button type="submit" class="bg-gradient-to-r from-brand-primary to-indigo-600 px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest text-white hover:shadow-[0_0_20px_rgba(0,98,255,0.4)] transition-all hover:scale-105 active:scale-95">
                Kirim Inputan
            </button>
        </div>
    </form>
</div>
@endsection
