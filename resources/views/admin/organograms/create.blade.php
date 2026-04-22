@extends('admin.layout')

@section('title', 'Tambah Struktur Organisasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center gap-4 bg-slate-900/50 backdrop-blur-2xl p-8 rounded-3xl border border-white/5 shadow-2xl">
        <a href="{{ route('admin.organograms.index') }}" class="h-10 w-10 bg-white/5 hover:bg-white/10 rounded-2xl flex items-center justify-center text-slate-400 hover:text-white transition-all">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        </a>
        <div>
            <h2 class="text-xl font-black text-white tracking-tight font-outfit italic uppercase">Tambah Anggota</h2>
            <p class="text-[10px] text-slate-500 mt-1 font-black uppercase tracking-widest">Registrasi Struktur Logistik Baru</p>
        </div>
    </div>

    <form action="{{ route('admin.organograms.store') }}" method="POST" enctype="multipart/form-data" class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl p-8 space-y-8">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="space-y-3">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Jabatan <span class="text-rose-500">*</span></label>
                <input type="text" name="position" value="{{ old('position') }}" required class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-brand-primary/50 focus:border-brand-primary outline-none transition-all placeholder:text-slate-600" placeholder="Contoh: Karolog Polda NTB">
                @error('position') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-3">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-brand-primary/50 focus:border-brand-primary outline-none transition-all placeholder:text-slate-600" placeholder="Contoh: SAPTO PRIYONO">
                @error('name') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-3">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Pangkat</label>
                <input type="text" name="rank" value="{{ old('rank') }}" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-brand-primary/50 focus:border-brand-primary outline-none transition-all placeholder:text-slate-600" placeholder="Contoh: KOMBES POL">
                @error('rank') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-3">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Atasan (Parent)</label>
                <select name="parent_id" class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-brand-primary/50 focus:border-brand-primary outline-none transition-all">
                    <option value="">-- Pucuk Pimpinan (Top Level) --</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                            {{ $parent->position }} ({{ $parent->name }})
                        </option>
                    @endforeach
                </select>
                @error('parent_id') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>

            <div class="space-y-3">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Nomor Urut (Sebelah Menyebelah)</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" required class="w-full bg-slate-800/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:ring-2 focus:ring-brand-primary/50 focus:border-brand-primary outline-none transition-all" placeholder="0">
                <p class="text-[9px] text-slate-500 font-bold">Digunakan untuk mensortir posisi anggota dengan atasan yang sama.</p>
                @error('order') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>
            
            <div class="col-span-1 md:col-span-2 space-y-3">
                <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Foto Anggota (Opsional)</label>
                <div class="relative flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-48 border-2 border-slate-700 border-dashed rounded-2xl cursor-pointer bg-slate-800/30 hover:bg-slate-800/50 transition-all group overflow-hidden">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-10 h-10 mb-4 text-slate-500 group-hover:text-brand-primary transition-colors" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-slate-400 font-bold"><span class="text-brand-primary">Klik untuk unggah</span> atau seret file</p>
                            <p class="text-xs text-slate-500">PNG, JPG atau WEBP (MAX. 2MB)</p>
                        </div>
                        <input id="dropzone-file" type="file" name="photo" class="hidden" accept="image/*" />
                    </label>
                </div>
                @error('photo') <span class="text-xs text-rose-500 font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="pt-6 border-t border-white/5 flex justify-end">
            <button type="submit" class="bg-brand-primary text-white px-10 py-4 rounded-xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-brand-primary/20 hover:bg-brand-dark transition-all italic">
                Simpan Anggota
            </button>
        </div>
    </form>
</div>
@endsection
