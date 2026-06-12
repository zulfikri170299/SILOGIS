@extends('layout')

@section('content')
<!-- Custom Modern CSS for BWS -->
<style>
    .bws-hero {
        position: relative;
        background: url('{{ asset('LB.png') }}') no-repeat center center;
        background-size: cover;
        min-height: 50vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 60px;
        padding-bottom: 40px;
    }
    .bws-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom, rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 1));
    }
    .step-card {
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .step-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.2);
    }
</style>

<!-- Hero Section -->
<section class="bws-hero overflow-hidden relative">
    <div class="relative z-20 text-center px-4 max-w-4xl mx-auto pt-4 md:mt-10">
        @php
            $siteProfile = \App\Models\Profile::first();
        @endphp

        @if($siteProfile && $siteProfile->bws_logo)
            <div class="inline-flex justify-center mb-6">
                <img src="{{ asset('storage/' . $siteProfile->bws_logo) }}" class="h-20 md:h-24 w-auto object-contain" alt="BWS Logo">
            </div>
        @else
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-amber-500/10 border border-amber-500/20 text-amber-500 mb-4 md:mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span class="text-sm font-bold uppercase tracking-widest">Layanan Pengaduan BWS</span>
            </div>
        @endif

        <h1 class="text-2xl sm:text-4xl md:text-6xl font-black text-white uppercase tracking-tight mb-2 md:mb-4 font-outfit leading-tight break-words">
            Biro Logistik <br class="md:hidden" /><span class="text-amber-500">Whistleblowing System</span>
        </h1>
        <p class="text-slate-300 text-sm md:text-lg max-w-3xl mx-auto font-medium px-2 pb-4 md:pb-6">
            Sistem pelaporan online terpadu. Sampaikan pengaduan atau aspirasi Anda secara aman dan rahasia ke Bagian terkait.
        </p>
    </div>
</section>

<!-- Form Section -->
<section class="bg-[#0f172a] py-16 px-4 md:px-8 min-h-screen relative -mt-10" x-data="{ 
    step: {{ session('success') || $errors->any() ? 2 : 1 }}, 
    bagian: '{{ old('bagian') }}' 
}">
    <div class="max-w-5xl mx-auto relative z-30">
        @if(session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 p-6 rounded-2xl mb-8 flex items-center gap-4 shadow-lg shadow-green-500/10 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-r from-green-500/0 via-green-500/10 to-green-500/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-1000"></div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center text-white shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-black uppercase tracking-wider mb-1">Berhasil!</h3>
                    <p class="font-medium text-sm text-green-400">{{ session('success') }}</p>
                </div>
                <button type="button" @click="step = 1; bagian = ''" class="ml-auto px-4 py-2 bg-green-500 text-white rounded-lg text-sm font-bold shadow-md hover:bg-green-600 transition-colors uppercase tracking-wider">Lapor Lagi</button>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 p-6 rounded-2xl mb-8">
                <div class="flex items-center gap-3 mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-lg font-black uppercase tracking-wider">Periksa Kembali Data Anda</h3>
                </div>
                <ul class="list-disc list-inside text-sm space-y-1 ml-2 font-medium">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('portal.bws.store') }}" method="POST" enctype="multipart/form-data" class="relative">
            @csrf
            
            <!-- Step Indicators -->
            <div class="flex items-center justify-center mb-12 relative z-10" x-show="!{{ session('success') ? 'true' : 'false' }}">
                <div class="flex items-center w-full max-w-sm relative">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-full h-1 bg-slate-800 rounded-full z-0"></div>
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-amber-500 rounded-full z-0 transition-all duration-500" :style="'width: ' + (step === 2 ? '100%' : '0%')"></div>
                    
                    <button type="button" @click="step = 1" class="relative z-10 flex flex-col items-center gap-3 w-1/2 cursor-pointer group">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-black text-lg transition-all duration-300 ring-4 ring-[#0f172a]" 
                             :class="step >= 1 ? 'bg-amber-500 text-[#0f172a] shadow-[0_0_15px_rgba(245,158,11,0.5)]' : 'bg-slate-800 text-slate-500'">1</div>
                        <span class="text-xs font-black uppercase tracking-widest transition-colors" :class="step >= 1 ? 'text-amber-500' : 'text-slate-500'">Pilih Bagian</span>
                    </button>
                    
                    <div class="relative z-10 flex flex-col items-center gap-3 w-1/2">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-black text-lg transition-all duration-300 ring-4 ring-[#0f172a]" 
                             :class="step >= 2 ? 'bg-amber-500 text-[#0f172a] shadow-[0_0_15px_rgba(245,158,11,0.5)]' : 'bg-slate-800 text-slate-500'">2</div>
                        <span class="text-xs font-black uppercase tracking-widest transition-colors" :class="step >= 2 ? 'text-amber-500' : 'text-slate-500'">Isi Formulir</span>
                    </div>
                </div>
            </div>

            <!-- STEP 1: PILIH BAGIAN -->
            <div x-show="step === 1 && !{{ session('success') ? 'true' : 'false' }}" x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="bg-slate-900 border border-slate-800 rounded-[2rem] p-5 md:p-8 shadow-2xl">
                <div class="text-center mb-8 md:mb-10">
                    <h2 class="text-2xl md:text-3xl font-black text-white uppercase tracking-wider mb-2 md:mb-3">Tujuan Pelaporan</h2>
                    <p class="text-xs md:text-sm text-slate-400 font-medium px-2">Silakan pilih bagian/satuan kerja tujuan dari pengaduan Anda.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    @php
                        $bagians = ['SUBBAGRENMIN', 'BAG FASKON', 'BAG PAL', 'BAG INFOLOG', 'BAG ADA', 'BAG BEKUM', 'URGUDANG'];
                    @endphp
                    @foreach($bagians as $bag)
                        <label class="cursor-pointer group step-card relative overflow-hidden rounded-2xl">
                            <input type="radio" name="bagian" value="{{ $bag }}" x-model="bagian" class="hidden">
                            <div class="h-full bg-slate-800/50 border-2 rounded-2xl p-4 md:p-6 transition-all duration-300 flex flex-row items-center text-left gap-3 md:gap-4"
                                 :class="bagian === '{{ $bag }}' ? 'border-amber-500 bg-amber-500/10' : 'border-slate-700/50 hover:border-slate-600 group-hover:bg-slate-800'">
                                <div class="w-10 h-10 md:w-14 md:h-14 shrink-0 rounded-full flex items-center justify-center transition-colors"
                                     :class="bagian === '{{ $bag }}' ? 'bg-amber-500 text-slate-900 shadow-[0_0_20px_rgba(245,158,11,0.4)]' : 'bg-slate-700 text-slate-400 group-hover:text-white group-hover:bg-slate-600'">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                </div>
                                <span class="font-black text-xs md:text-sm uppercase tracking-widest transition-colors flex-1"
                                      :class="bagian === '{{ $bag }}' ? 'text-amber-500' : 'text-slate-300 group-hover:text-white'">{{ $bag }}</span>
                                
                                <div class="text-amber-500 transition-all duration-300 shrink-0" x-show="bagian === '{{ $bag }}'" x-transition:enter="transition scale-0" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100">
                                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="mt-8 md:mt-12 flex justify-center border-t border-slate-800 pt-6 md:pt-8">
                    <button type="button" @click="if(bagian) step = 2" :disabled="!bagian" 
                            class="px-6 md:px-10 py-3 md:py-4 rounded-xl font-black uppercase tracking-wider text-xs md:text-sm transition-all shadow-xl flex items-center gap-3 disabled:opacity-50 disabled:cursor-not-allowed group w-full md:w-auto justify-center"
                            :class="bagian ? 'bg-amber-500 text-slate-900 hover:bg-amber-400 hover:shadow-[0_0_20px_rgba(245,158,11,0.4)] hover:-translate-y-1' : 'bg-slate-800 text-slate-500'">
                        Lanjutkan Isi Form
                        <svg class="w-4 h-4 md:w-5 md:h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </div>

            <!-- STEP 2: ISI FORMULIR -->
            <div x-show="step === 2 && !{{ session('success') ? 'true' : 'false' }}" x-cloak x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" class="bg-slate-900 border border-slate-800 rounded-[2rem] p-5 md:p-8 shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/5 rounded-full blur-[80px] pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-500/5 rounded-full blur-[80px] pointer-events-none"></div>
                
                <div class="flex items-center justify-between mb-8 md:mb-10 border-b border-slate-800 pb-5 md:pb-6 relative z-10">
                    <div>
                        <h2 class="text-xl md:text-3xl font-black text-white uppercase tracking-wider mb-1 md:mb-2">Formulir Pengaduan</h2>
                        <div class="flex items-center gap-2">
                            <span class="text-slate-400 text-sm">Tujuan:</span>
                            <span class="px-3 py-1 bg-amber-500/10 text-amber-500 text-xs font-black rounded-lg border border-amber-500/20" x-text="bagian"></span>
                        </div>
                    </div>
                    <button type="button" @click="step = 1" class="w-10 h-10 rounded-full border border-slate-700 flex items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 hover:border-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                    <!-- NAMA -->
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-300 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                            Nama Pelapor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Masukkan Nama Lengkap"
                               class="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all font-medium placeholder-slate-500">
                    </div>

                    <!-- NOMOR HP -->
                    <div class="space-y-2">
                        <label class="text-xs font-black text-slate-300 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                            Nomor Handphone / WA <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nomor_hp" value="{{ old('nomor_hp') }}" required placeholder="Contoh: 08123456789"
                               class="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all font-medium placeholder-slate-500">
                    </div>

                    <!-- ADUAN -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-black text-slate-300 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                            Rincian Pengaduan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="aduan" rows="5" required placeholder="Tuliskan secara jelas dan detail kronologi pengaduan atau keluhan Anda..."
                                  class="w-full bg-slate-800/50 border border-slate-700 text-white rounded-xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all font-medium resize-y placeholder-slate-500">{{ old('aduan') }}</textarea>
                    </div>

                    <!-- BUKTI DUKUNG -->
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs font-black text-slate-300 uppercase tracking-widest ml-1 flex items-center gap-1.5">
                            Bukti Pendukung <span class="text-red-500">*</span>
                        </label>
                        <div class="w-full relative group">
                            <input type="file" name="bukti_dukung" required accept=".pdf,.png,.jpg,.jpeg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                            <div class="w-full bg-slate-800/30 border-2 border-dashed border-slate-700 rounded-2xl p-8 transition-all group-hover:border-amber-500 group-hover:bg-slate-800/60 flex flex-col items-center justify-center text-center relative z-10 pointer-events-none">
                                <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 mb-4 group-hover:scale-110 group-hover:text-amber-500 group-hover:shadow-[0_0_20px_rgba(245,158,11,0.2)] transition-all">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                </div>
                                <h4 class="text-sm font-black text-white uppercase tracking-wider mb-1">Unggah Dokumen (Wajib)</h4>
                                <p class="text-xs text-slate-400 font-medium">Klik atau seret file ke sini</p>
                                <p class="text-[10px] text-slate-500 mt-2 italic">* Format PDF/JPG/PNG max 5MB</p>
                            </div>
                            <div class="mt-3 text-xs text-amber-500 font-bold px-2 flex justify-between items-center z-10 relative pointer-events-none display-filename">
                                <!-- Filename will be updated via JS if needed, or default text -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 md:mt-8 pt-6 md:pt-8 border-t border-slate-800 flex justify-end relative z-10">
                    <button type="submit" class="px-6 md:px-10 py-3 md:py-4 w-full md:w-auto justify-center bg-amber-500 text-slate-900 rounded-xl font-black uppercase tracking-wider text-xs md:text-sm transition-all shadow-[0_10px_20px_-10px_rgba(245,158,11,0.6)] hover:bg-amber-400 hover:shadow-[0_15px_30px_-5px_rgba(245,158,11,0.8)] hover:-translate-y-1 flex items-center gap-3">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Kirim Pengaduan
                    </button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const fileInput = document.querySelector('input[name="bukti_dukung"]');
        const filenameDisplay = document.querySelector('.display-filename');
        if(fileInput && filenameDisplay) {
            fileInput.addEventListener('change', (e) => {
                if(e.target.files.length > 0) {
                    filenameDisplay.innerHTML = `<span class="flex items-center gap-2"><svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> ${e.target.files[0].name}</span>`;
                } else {
                    filenameDisplay.innerHTML = '';
                }
            });
        }
    });
</script>
@endsection
