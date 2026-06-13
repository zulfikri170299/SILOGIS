@extends('admin.layout')

@section('title', 'Edit Logo Website')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="space-y-8">
        
        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
            <div class="bg-slate-900 px-8 py-6 flex justify-between items-center border-b border-white/5">
                <h2 class="text-white font-black italic tracking-tight flex items-center gap-3 font-outfit uppercase">
                    <svg class="h-5 w-5 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Edit Logo Website SILOGIS
                </h2>
            </div>

            @if(session('success'))
                <div class="bg-emerald-500/10 border-l-4 border-emerald-500 p-4 m-8 mb-0">
                    <p class="text-emerald-400 font-bold text-sm">{{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.logo.update') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-10">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <h3 class="text-brand-primary font-black uppercase tracking-widest text-[10px] italic border-b border-white/5 pb-2">Logo Utama</h3>
                    
                    <div class="space-y-4">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 block">Logo SILOGIS</label>
                        <div class="flex flex-col sm:flex-row items-center gap-8">
                            <div class="h-32 w-auto min-w-[150px] bg-slate-800 rounded-2xl overflow-hidden border border-white/5 flex items-center justify-center relative group shadow-2xl p-4">
                                <img id="logo-preview" src="{{ $profile->logo ? asset('storage/' . $profile->logo) : asset('log polri.png') }}" 
                                     class="h-full w-full object-contain" alt="Logo Preview">
                            </div>
                            <div class="flex-1 text-center sm:text-left">
                                <label class="cursor-pointer bg-slate-800/50 hover:bg-brand-primary/20 text-slate-300 hover:text-white font-black py-4 px-8 rounded-2xl border-2 border-dashed border-white/10 transition-all inline-block">
                                    <span class="text-[10px] uppercase tracking-widest">Ganti Logo</span>
                                    <input type="file" name="logo" accept="image/*" class="sr-only" onchange="previewLogo(event)"/>
                                </label>
                                <p class="text-[9px] text-slate-500 mt-3 uppercase font-black tracking-widest">Format PNG dengan background transparan disarankan</p>
                                @error('logo') <p class="text-xs text-rose-500 font-bold mt-2">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t border-white/5 flex justify-end">
                    <button type="submit" class="bg-brand-primary text-white px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-primary/40 hover:scale-105 transition-all active:scale-[0.98] italic">
                        Simpan Logo
                    </button>
                </div>
                </div>
            </form>
        </div>

        <!-- Pengaturan Logo WBS Card -->
        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden p-8">
            <h3 class="text-brand-primary font-black uppercase tracking-widest text-[10px] italic border-b border-white/5 pb-2 mb-6">Layanan WBS</h3>
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Logo WBS -->
                <div class="flex-1 bg-slate-900 border border-white/5 rounded-2xl p-6 flex flex-col justify-center">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-4">Logo WBS</h4>
                    <div class="flex items-center gap-6">
                        <div class="h-20 w-20 bg-slate-800 rounded-xl overflow-hidden border border-white/5 flex items-center justify-center relative group p-2 shrink-0">
                            @if($profile && $profile->bws_logo)
                                <img id="bws-preview" src="{{ asset('storage/' . $profile->bws_logo) }}" class="h-full w-full object-contain" alt="WBS Logo">
                            @else
                                <div id="bws-placeholder" class="text-slate-600 flex flex-col items-center">
                                    <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <img id="bws-preview-fallback" src="#" class="h-full w-full object-contain hidden" alt="Preview">
                        </div>
                        <div>
                            <form action="{{ route('admin.bws.logo.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                                @csrf
                                @method('PUT')
                                <div class="flex flex-wrap gap-2">
                                    <label class="cursor-pointer bg-slate-800/50 hover:bg-amber-500/20 text-slate-300 hover:text-white font-black py-2 px-4 rounded-xl border border-dashed border-white/10 transition-all inline-block">
                                        <span class="text-[9px] uppercase tracking-widest">Pilih Gambar</span>
                                        <input type="file" name="bws_logo" accept="image/*" class="sr-only" onchange="previewBwsImage(event)" required />
                                    </label>
                                    <button type="submit" class="text-[9px] font-black uppercase tracking-widest bg-brand-primary text-white py-2 px-4 rounded-xl shadow-lg hover:scale-105 transition-all">
                                        Simpan Logo
                                    </button>
                                </div>
                                @error('bws_logo') <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Dynamic QR Code Card -->
                <div class="flex-1 bg-slate-900 border border-white/5 rounded-2xl p-6 flex flex-row items-center gap-6 shadow-xl">
                    <div class="bg-white p-3 rounded-xl shrink-0 relative">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('portal.bws.index')) }}&ecc=H" alt="WBS QR Code" class="w-20 h-20 sm:w-24 sm:h-24 object-contain">
                        <div class="absolute inset-0 m-auto w-6 h-6 sm:w-8 sm:h-8 bg-white p-1 rounded-md shadow-sm flex items-center justify-center">
                            <img id="qr-logo-preview" src="{{ $profile->bws_logo ? asset('storage/' . $profile->bws_logo) : asset('log polri.png') }}" class="w-full h-full object-contain" alt="Logo WBS">
                        </div>
                    </div>
                    <div class="flex flex-col justify-center">
                        <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2">QR Layanan WBS</h4>
                        <p class="text-[10px] text-slate-400 leading-relaxed max-w-[200px] mb-4 font-bold">Otomatis beradaptasi dengan perubahan domain situs.</p>
                        <a href="https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data={{ urlencode(route('portal.bws.index')) }}&ecc=H" target="_blank" class="inline-block px-4 py-2 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all w-max">
                            Unduh Resolusi Tinggi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewLogo(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('logo-preview');
            output.src = reader.result;
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    function previewBwsImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('bws-preview-fallback');
            const currentPreview = document.getElementById('bws-preview');
            const placeholder = document.getElementById('bws-placeholder');
            const qrPreview = document.getElementById('qr-logo-preview');
            
            if(currentPreview) currentPreview.classList.add('hidden');
            if(placeholder) placeholder.classList.add('hidden');
            
            output.src = reader.result;
            output.classList.remove('hidden');
            if(qrPreview) qrPreview.src = reader.result;
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
