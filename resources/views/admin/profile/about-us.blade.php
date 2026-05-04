@extends('admin.layout')

@section('title', 'Tentang Kami')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="space-y-8">
        
        <!-- About Us Form Container -->
        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
            <div class="bg-slate-900 px-8 py-6 flex justify-between items-center border-b border-white/5">
                <h2 class="text-white font-black italic tracking-tight flex items-center gap-3 font-outfit uppercase">
                    <svg class="h-5 w-5 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Data Tentang Kami
                </h2>
            </div>

            @if(session('success'))
                <div class="bg-emerald-500/10 border-l-4 border-emerald-500 p-4 m-8 mb-0">
                    <p class="text-emerald-400 font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.about-us.update') }}" method="POST" class="p-8 space-y-10">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="space-y-2">
                        <label for="about_short" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Profil Singkat Organisasi</label>
                        <textarea id="about_short" name="about_short" rows="4"
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                            placeholder="Masukkan Profil Singkat...">{{ old('about_short', $profile?->about_short) }}</textarea>
                        @error('about_short') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="history" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Sejarah Organisasi</label>
                        <textarea id="history" name="history" rows="6"
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                            placeholder="Masukkan Sejarah...">{{ old('history', $profile?->history) }}</textarea>
                        @error('history') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="values" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Nilai-Nilai Organisasi (Gunakan tanda • untuk setiap poin)</label>
                        <textarea id="values" name="values" rows="4"
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                            placeholder="Masukkan Nilai-nilai...">{{ old('values', $profile?->values) }}</textarea>
                        @error('values') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-10 border-t border-white/5 flex justify-end">
                    <button type="submit" class="bg-brand-primary text-white px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-primary/40 hover:scale-105 transition-all active:scale-[0.98] italic">
                        Simpan Data Tentang Kami
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
