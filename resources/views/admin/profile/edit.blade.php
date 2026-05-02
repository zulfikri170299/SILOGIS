@extends('admin.layout')

@section('title', 'Edit Profil & Visi Misi')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="space-y-8">
        
        <!-- Profile Form Container -->
        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
            <div class="bg-slate-900 px-8 py-6 flex justify-between items-center border-b border-white/5">
                <h2 class="text-white font-black italic tracking-tight flex items-center gap-3 font-outfit uppercase">
                    <svg class="h-5 w-5 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    Edit Profil Institusi
                </h2>
            </div>

            @if(session('success'))
                <div class="bg-emerald-500/10 border-l-4 border-emerald-500 p-4 m-8 mb-0">
                    <p class="text-emerald-400 font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.profile-site.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-10">
                @csrf
                @method('PUT')
                
                <!-- Leader Section -->
                <div class="space-y-6">
                    <h3 class="text-brand-primary font-black uppercase tracking-widest text-[10px] italic border-b border-white/5 pb-2">Profil Pimpinan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="name" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Nama Lengkap & Gelar</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $profile->name) }}" required
                                class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                                placeholder="Contoh: KOMBES POL. PUJI PRAYITNO, S.I.K., M.H.">
                            @error('name') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="title" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Jabatan</label>
                            <input id="title" name="title" type="text" value="{{ old('title', $profile->title) }}" required
                                class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                                placeholder="Contoh: KAROLOG POLDA NTB">
                            @error('title') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 block">Foto Pimpinan</label>
                        <div class="flex flex-col sm:flex-row items-center gap-8">
                            <div class="h-48 w-40 bg-slate-800 rounded-2xl overflow-hidden border border-white/5 flex items-center justify-center relative group shadow-2xl">
                                <img id="image-preview" src="{{ $profile->photo ? (str_contains($profile->photo, 'pimpinan.png') ? asset($profile->photo) : asset('storage/' . $profile->photo)) : '#' }}" 
                                     class="h-full w-full object-cover" alt="Preview">
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <label class="cursor-pointer bg-slate-800/50 hover:bg-brand-primary/20 text-slate-300 hover:text-white font-black py-4 px-8 rounded-2xl border-2 border-dashed border-white/10 transition-all inline-block">
                                    <span class="text-[10px] uppercase tracking-widest">Ganti Foto Visioner</span>
                                    <input type="file" name="photo" accept="image/*" class="sr-only" onchange="previewImage(event)"/>
                                </label>
                                <p class="text-[9px] text-slate-500 mt-3 uppercase font-black tracking-widest">Rasio 4:5 Sangat Disarankan</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="quote" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Kata Bijak Pimpinan</label>
                        <textarea id="quote" name="quote" rows="3" required
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold italic transition-all placeholder:text-slate-600"
                            placeholder="Masukkan kata sambutan pimpinan...">{{ old('quote', $profile->quote) }}</textarea>
                        @error('quote') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Vision Mission Section -->
                <div class="space-y-6">
                    <h3 class="text-brand-primary font-black uppercase tracking-widest text-[10px] italic border-b border-white/5 pb-2">Visi & Misi Strategis</h3>
                    
                    <div class="space-y-2">
                        <label for="vision" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Visi Institusi</label>
                        <textarea id="vision" name="vision" rows="3" required
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold italic transition-all placeholder:text-slate-600"
                            placeholder="Masukkan Visi...">{{ old('vision', $profile->vision) }}</textarea>
                        @error('vision') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="mission" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Misi (Gunakan tanda • untuk setiap poin)</label>
                        <textarea id="mission" name="mission" rows="6" required
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold italic transition-all placeholder:text-slate-600"
                            placeholder="Contoh: &#10;• Poin pertama&#10;• Poin kedua">{{ old('mission', $profile->mission) }}</textarea>
                        @error('mission') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="about_short" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Profil Singkat Organisasi</label>
                        <textarea id="about_short" name="about_short" rows="4"
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                            placeholder="Masukkan Profil Singkat...">{{ old('about_short', $profile->about_short) }}</textarea>
                        @error('about_short') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="history" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Sejarah Organisasi</label>
                        <textarea id="history" name="history" rows="6"
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                            placeholder="Masukkan Sejarah...">{{ old('history', $profile->history) }}</textarea>
                        @error('history') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="values" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Nilai-Nilai Organisasi (Gunakan tanda • untuk setiap poin)</label>
                        <textarea id="values" name="values" rows="4"
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                            placeholder="Masukkan Nilai-nilai...">{{ old('values', $profile->values) }}</textarea>
                        @error('values') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-4 pt-4">
                        <h3 class="text-brand-primary font-black uppercase tracking-widest text-[10px] italic border-b border-white/5 pb-2">Portal Configuration</h3>
                        <div class="space-y-2">
                            <label for="ecosystem_description" class="text-[10px] font-black uppercase tracking-widest text-slate-500">Deskripsi Layanan Digital (Home)</label>
                            <textarea id="ecosystem_description" name="ecosystem_description" rows="3" 
                                class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold italic transition-all placeholder:text-slate-600"
                                placeholder="Masukkan Deskripsi Ekosistem...">{{ old('ecosystem_description', $profile->ecosystem_description) }}</textarea>
                            @error('ecosystem_description') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>

                        <div class="space-y-4 pt-4">
                            <label for="whatsapp" class="text-[10px] font-black uppercase tracking-widest text-slate-500 block">Nomor WhatsApp Konsultasi (Format: 628123xxx)</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-emerald-500 group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .004 5.408.001 12.045a11.815 11.815 0 001.591 5.976L0 24l6.135-1.61a11.803 11.803 0 005.911 1.586h.005c6.635 0 12.045-5.408 12.048-12.047a11.8 11.8 0 00-3.543-8.514z"/></svg>
                                </div>
                                <input id="whatsapp" name="whatsapp" type="text" value="{{ old('whatsapp', $profile->whatsapp) }}"
                                    class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 pl-14 text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm font-bold transition-all placeholder:text-slate-600"
                                    placeholder="Contoh: 6281234567890">
                            </div>
                            @error('whatsapp') <p class="text-xs text-rose-500 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t border-white/5 flex justify-end">
                    <button type="submit" class="bg-brand-primary text-white px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-primary/40 hover:scale-105 transition-all active:scale-[0.98] italic">
                        Simpan Strategi & Profil
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
                    Setiap perubahan pada Visi, Misi, dan Profil Pimpinan akan langsung diterapkan ke seluruh ekosistem digital (Public Facing Portal & Internal Modules) secara real-time. Jagalah integritas data institusi untuk menjaga wibawa komando.
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('image-preview');
            output.src = reader.result;
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
