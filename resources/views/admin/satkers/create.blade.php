@extends('admin.layout')

@section('title', 'Tambah satker')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.satkers.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-white transition-colors mb-4">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Katalog satker
    </a>
    <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight">Tambah satker</h2>
</div>

<div class="max-w-2xl bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl p-8">
    <form action="{{ route('admin.satkers.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Nama satker</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all">
            @error('name')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="urutan" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Urutan (Opsional)</label>
            <input type="number" id="urutan" name="urutan" value="{{ old('urutan') }}" placeholder="Contoh: 1, 2, 3..."
                class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all">
            <p class="mt-1 text-[10px] text-slate-500 font-medium">Satker akan diurutkan dari angka terkecil ke terbesar saat ditampilkan.</p>
            @error('urutan')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Deskripsi (Opsional)</label>
            <textarea id="description" name="description" rows="4"
                class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-4 border-t border-white/5 flex justify-end">
            <button type="submit" class="bg-gradient-to-r from-brand-primary to-indigo-600 px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest text-white hover:shadow-[0_0_20px_rgba(0,98,255,0.4)] transition-all hover:scale-105 active:scale-95">
                Simpan satker
            </button>
        </div>
    </form>
</div>
@endsection
