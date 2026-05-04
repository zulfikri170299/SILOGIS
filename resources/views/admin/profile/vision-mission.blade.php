@extends('admin.layout')

@section('title', 'Visi & Misi Strategis')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="space-y-8">
        
        <!-- Profile Form Container -->
        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
            <div class="bg-slate-900 px-8 py-6 flex justify-between items-center border-b border-white/5">
                <h2 class="text-white font-black italic tracking-tight flex items-center gap-3 font-outfit uppercase">
                    <svg class="h-5 w-5 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Visi & Misi Institusi
                </h2>
            </div>

            @if(session('success'))
                <div class="bg-emerald-500/10 border-l-4 border-emerald-500 p-4 m-8 mb-0">
                    <p class="text-emerald-400 font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.vision-mission.update') }}" method="POST" class="p-8 space-y-10">
                @csrf
                @method('PUT')

                <!-- Vision Mission Section -->
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label for="vision" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Visi Institusi</label>
                        <textarea id="vision" name="vision" rows="3" required
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold italic transition-all placeholder:text-slate-600"
                            placeholder="Masukkan Visi...">{{ old('vision', $profile?->vision) }}</textarea>
                        @error('vision') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="mission" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Misi (Gunakan tanda • untuk setiap poin)</label>
                        <textarea id="mission" name="mission" rows="6" required
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold italic transition-all placeholder:text-slate-600"
                            placeholder="Contoh: &#10;• Poin pertama&#10;• Poin kedua">{{ old('mission', $profile?->mission) }}</textarea>
                        @error('mission') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>


                </div>

                <div class="pt-10 border-t border-white/5 flex justify-end">
                    <button type="submit" class="bg-brand-primary text-white px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-primary/40 hover:scale-105 transition-all active:scale-[0.98] italic">
                        Simpan Visi & Misi
                    </button>
                </div>
            </form>
        </div>

        <!-- Institutional Protocol Shortcut -->
        <div class="bg-brand-primary rounded-[2rem] p-8 text-white shadow-2xl shadow-brand-primary/20 italic relative overflow-hidden group">
            <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(circle_at_2px_2px,rgba(255,255,255,0.4)_1px,transparent_0)] [background-size:24px_24px]"></div>
            <div class="relative z-10">
                <h4 class="text-[10px] font-black uppercase tracking-[0.4em] mb-4">Institutional Protocol</h4>
                <p class="text-sm text-blue-50 font-bold leading-relaxed opacity-90 group-hover:opacity-100 transition-opacity">
                    Setiap perubahan pada Visi dan Misi akan langsung diterapkan ke public facing portal. Jagalah integritas data institusi untuk menjaga wibawa komando.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
