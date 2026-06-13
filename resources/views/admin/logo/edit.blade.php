@extends('admin.layout')

@section('title', 'Menu Setting')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    <div class="space-y-8">
        
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight flex items-center gap-3">
                <svg class="h-6 w-6 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                Pengaturan Sistem SILOGIS
            </h2>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border-l-4 border-emerald-500 p-4 rounded-xl mb-8">
                <p class="text-emerald-400 font-bold text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <!-- ROW 1: LOGOS & QR -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Logo SILOGIS -->
            <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl p-8 flex flex-col">
                <h3 class="text-brand-primary font-black uppercase tracking-widest text-[10px] italic border-b border-white/5 pb-2 mb-6">Logo Utama SILOGIS</h3>
                <form action="{{ route('admin.logo.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex-1 flex flex-col items-center justify-center text-center space-y-6">
                        <div class="h-32 w-32 bg-slate-800 rounded-2xl overflow-hidden border border-brand-primary/20 flex items-center justify-center relative shadow-inner p-4 group hover:border-brand-primary/50 transition-colors">
                            <img id="logo-preview" src="{{ $profile->logo ? asset('storage/' . $profile->logo) : asset('log polri.png') }}" class="h-full w-full object-contain transition-transform duration-300 group-hover:scale-110" alt="Logo Preview">
                        </div>
                        
                        <div class="w-full">
                            <label class="cursor-pointer bg-slate-800/50 hover:bg-brand-primary/20 text-slate-300 hover:text-white font-black py-3 px-6 rounded-xl border border-dashed border-white/10 transition-all inline-block w-full">
                                <span class="text-[10px] uppercase tracking-widest">Pilih Logo Baru</span>
                                <input type="file" name="logo" accept="image/*" class="sr-only" onchange="previewLogo(event)"/>
                            </label>
                            <p class="text-[9px] text-slate-500 mt-3 font-bold italic">Disarankan PNG transparan.</p>
                            @error('logo') <p class="text-xs text-rose-500 font-bold mt-2">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" class="mt-8 w-full bg-brand-primary text-white py-4 rounded-xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-brand-primary/30 hover:scale-[1.02] transition-all">
                        Simpan Logo
                    </button>
                </form>
            </div>

            <!-- Logo WBS -->
            <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl p-8 flex flex-col">
                <h3 class="text-amber-500 font-black uppercase tracking-widest text-[10px] italic border-b border-white/5 pb-2 mb-6">Logo Layanan WBS</h3>
                <form action="{{ route('admin.bws.logo.update') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1">
                    @csrf
                    @method('PUT')
                    
                    <div class="flex-1 flex flex-col items-center justify-center text-center space-y-6">
                        <div class="h-32 w-32 bg-slate-800 rounded-2xl overflow-hidden border border-amber-500/20 flex items-center justify-center relative shadow-inner p-4 group hover:border-amber-500/50 transition-colors">
                            @if($profile && $profile->bws_logo)
                                <img id="bws-preview" src="{{ asset('storage/' . $profile->bws_logo) }}" class="h-full w-full object-contain transition-transform duration-300 group-hover:scale-110" alt="WBS Logo">
                            @else
                                <div id="bws-placeholder" class="text-slate-600 flex flex-col items-center">
                                    <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                            <img id="bws-preview-fallback" src="#" class="h-full w-full object-contain hidden" alt="Preview">
                        </div>
                        
                        <div class="w-full">
                            <label class="cursor-pointer bg-slate-800/50 hover:bg-amber-500/20 text-slate-300 hover:text-white font-black py-3 px-6 rounded-xl border border-dashed border-white/10 transition-all inline-block w-full">
                                <span class="text-[10px] uppercase tracking-widest">Pilih Gambar</span>
                                <input type="file" name="bws_logo" accept="image/*" class="sr-only" onchange="previewBwsImage(event)" required />
                            </label>
                            <p class="text-[9px] text-slate-500 mt-3 font-bold italic">Untuk disisipkan di QR WBS.</p>
                            @error('bws_logo') <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <button type="submit" class="mt-8 w-full bg-amber-500 text-white py-4 rounded-xl font-black uppercase tracking-widest text-[10px] shadow-lg shadow-amber-500/30 hover:scale-[1.02] transition-all">
                        Simpan Logo WBS
                    </button>
                </form>
            </div>

            <!-- QR Code -->
            <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl p-8 flex flex-col">
                <h3 class="text-emerald-500 font-black uppercase tracking-widest text-[10px] italic border-b border-white/5 pb-2 mb-6">QR Layanan WBS</h3>
                
                <div class="flex-1 flex flex-col items-center justify-center text-center space-y-6">
                    <div class="bg-white p-3 rounded-2xl relative shadow-xl transform hover:scale-105 transition-transform duration-500 border-4 border-slate-800">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(route('portal.bws.index')) }}&ecc=H" alt="WBS QR Code" class="w-32 h-32 object-contain">
                        <div class="absolute inset-0 m-auto w-8 h-8 bg-white p-1 rounded shadow-sm flex items-center justify-center">
                            <img id="qr-logo-preview" src="{{ $profile->bws_logo ? asset('storage/' . $profile->bws_logo) : asset('log polri.png') }}" class="w-full h-full object-contain" alt="Logo WBS">
                        </div>
                    </div>
                    
                    <div class="w-full">
                        <p class="text-[10px] text-slate-400 font-bold leading-relaxed mb-5">QR ini otomatis beradaptasi. Cetak dan tempel di area layanan publik.</p>
                        <a href="https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data={{ urlencode(route('portal.bws.index')) }}&ecc=H" target="_blank" class="block w-full py-4 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all text-center">
                            Unduh Resolusi Tinggi
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- ROW 2: VISI, MISI, WHATSAPP -->
        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl p-8">
            <h3 class="text-brand-primary font-black uppercase tracking-widest text-[10px] italic border-b border-white/5 pb-2 mb-8 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                Informasi & Kontak Sistem
            </h3>
            
            <form action="{{ route('admin.logo.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-slate-800/30 p-8 rounded-3xl border border-white/5 shadow-inner">
                    <div class="space-y-4">
                        <label for="vision" class="text-[10px] font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            Visi
                        </label>
                        <textarea id="vision" name="vision" rows="5" class="w-full bg-slate-900 border border-white/10 rounded-2xl px-5 py-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all shadow-inner hover:border-white/20">{{ old('vision', $profile->vision ?? '') }}</textarea>
                        @error('vision') <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-4">
                        <label for="mission" class="text-[10px] font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                            Misi
                        </label>
                        <textarea id="mission" name="mission" rows="5" class="w-full bg-slate-900 border border-white/10 rounded-2xl px-5 py-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition-all shadow-inner hover:border-white/20">{{ old('mission', $profile->mission ?? '') }}</textarea>
                        @error('mission') <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="bg-slate-800/30 p-8 rounded-3xl border border-white/5 shadow-inner">
                    <div class="space-y-4 max-w-xl">
                        <label for="whatsapp" class="text-[10px] font-black uppercase tracking-widest text-slate-500 flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.099.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 3.825.001 6.938 3.113 6.939 6.938-.001 3.825-3.114 6.938-6.939 6.938z"/></svg>
                            Nomor WhatsApp
                        </label>
                        <input type="text" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $profile->whatsapp ?? '') }}" placeholder="Cth: 08123456789" class="w-full bg-slate-900 border border-white/10 rounded-2xl px-5 py-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all shadow-inner hover:border-white/20">
                        <p class="text-[9px] text-slate-500 font-bold italic mt-2">Nomor ini akan digunakan sebagai tombol hubungi kami / rujukan konsultasi.</p>
                        @error('whatsapp') <p class="text-[10px] text-rose-500 font-bold mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-brand-primary text-white px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-primary/40 hover:scale-105 transition-all active:scale-[0.98] italic">
                        Simpan Informasi
                    </button>
                </div>
            </form>
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
