@extends('admin.layout')
@section('title', 'Daftar Pengaduan WBS')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl sm:text-2xl font-black text-white uppercase tracking-tight">Pengaduan WBS</h2>
        <p class="text-xs sm:text-sm text-slate-400 mt-1">Kelola masuknya data Biro Logistik Whistleblowing System.</p>
    </div>
    <button type="button" onclick="document.getElementById('wbs-settings').classList.toggle('hidden')"
        class="flex items-center gap-2 px-4 py-2.5 bg-slate-800 border border-white/10 rounded-xl text-[9px] font-black uppercase tracking-widest text-slate-300 hover:text-white hover:border-amber-500/30 hover:bg-slate-800/80 transition-all shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        Pengaturan
    </button>
</div>

<div id="wbs-settings" class="hidden mb-8 transition-all">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengaturan Logo WBS Card -->
        <div class="p-6 bg-slate-900 border border-white/5 rounded-2xl shadow-xl flex flex-col justify-center">
            @php $profile = \App\Models\Profile::first(); @endphp
            <h3 class="text-brand-primary font-black uppercase tracking-widest text-[10px] mb-4">Pengaturan Logo WBS</h3>
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
        <div class="bg-slate-900 border border-white/5 rounded-2xl p-6 flex flex-row items-center gap-6 shadow-xl">
            <div class="bg-white p-3 rounded-xl shrink-0">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(route('portal.bws.index')) }}" alt="WBS QR Code" class="w-20 h-20 sm:w-24 sm:h-24 object-contain">
            </div>
            <div class="flex flex-col justify-center">
                <h3 class="text-xs font-black uppercase tracking-widest text-emerald-400 mb-2">QR Layanan WBS</h3>
                <p class="text-[10px] text-slate-400 leading-relaxed max-w-[200px] mb-4 font-bold">Otomatis beradaptasi dengan perubahan domain situs.</p>
                <a href="https://api.qrserver.com/v1/create-qr-code/?size=1000x1000&data={{ urlencode(route('portal.bws.index')) }}" target="_blank" class="inline-block px-4 py-2 bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all w-max">
                    Unduh Resolusi Tinggi
                </a>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-500/10 border border-green-500 text-green-500 p-4 rounded-xl mb-6 flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span class="text-sm font-bold">{{ session('success') }}</span>
    </div>
@endif

<!-- Filter & Actions Bar -->
<div class="bg-slate-900 border border-white/5 rounded-2xl p-4 mb-6">
    <form method="GET" action="{{ route('admin.bws.index') }}" class="flex flex-col lg:flex-row lg:items-end gap-4">
        <!-- Bagian Filter -->
        <div class="flex-1 min-w-0">
            <label class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-1.5">Bagian</label>
            <select name="bagian" class="w-full bg-slate-800 border border-white/10 rounded-xl text-white text-xs font-bold py-2.5 px-3 focus:border-brand-primary focus:ring-brand-primary">
                <option value="">Semua Bagian</option>
                @foreach(['SUBBAGRENMIN','BAG FASKON','BAG PAL','BAG INFOLOG','BAG ADA','BAG BEKUM','URGUDANG'] as $bag)
                    <option value="{{ $bag }}" {{ request('bagian') == $bag ? 'selected' : '' }}>{{ $bag }}</option>
                @endforeach
            </select>
        </div>
        <!-- Jenis Laporan Filter -->
        <div class="flex-1 min-w-0">
            <label class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-1.5">Jenis</label>
            <select name="jenis_laporan" class="w-full bg-slate-800 border border-white/10 rounded-xl text-white text-xs font-bold py-2.5 px-3 focus:border-brand-primary focus:ring-brand-primary">
                <option value="">Semua Jenis</option>
                @foreach(['KORUPSI','PUNGLI','KESEWENANG'] as $jenis)
                    <option value="{{ $jenis }}" {{ request('jenis_laporan') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                @endforeach
            </select>
        </div>
        <!-- Date From -->
        <div class="flex-1 min-w-0">
            <label class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-1.5">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ request('dari') }}" class="w-full bg-slate-800 border border-white/10 rounded-xl text-white text-xs font-bold py-2.5 px-3 focus:border-brand-primary focus:ring-brand-primary">
        </div>
        <!-- Date To -->
        <div class="flex-1 min-w-0">
            <label class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-1.5">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}" class="w-full bg-slate-800 border border-white/10 rounded-xl text-white text-xs font-bold py-2.5 px-3 focus:border-brand-primary focus:ring-brand-primary">
        </div>
        <!-- Per Page -->
        <div class="w-32 shrink-0">
            <label class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-1.5">Tampilkan</label>
            <select name="per_page" onchange="this.form.submit()" class="w-full bg-slate-800 border border-white/10 rounded-xl text-white text-xs font-bold py-2.5 px-3 focus:border-brand-primary focus:ring-brand-primary">
                @foreach([10, 25, 50, 100] as $pp)
                    <option value="{{ $pp }}" {{ request('per_page', 10) == $pp ? 'selected' : '' }}>{{ $pp }} Data</option>
                @endforeach
            </select>
        </div>
        <!-- Buttons -->
        <div class="flex gap-2 shrink-0">
            <button type="submit" class="bg-brand-primary text-white py-2.5 px-5 rounded-xl text-[9px] font-black uppercase tracking-widest hover:scale-105 transition-all shadow-lg">
                <svg class="w-4 h-4 inline -mt-0.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>Filter
            </button>
            <a href="{{ route('admin.bws.print', request()->only(['bagian','jenis_laporan','dari','sampai'])) }}" target="_blank" class="bg-emerald-600 text-white py-2.5 px-5 rounded-xl text-[9px] font-black uppercase tracking-widest hover:scale-105 transition-all shadow-lg inline-flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>Cetak PDF
            </a>
        </div>
    </form>
</div>

<!-- Data Table -->
<div class="bg-slate-900 border border-white/5 rounded-2xl shadow-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-800 text-slate-100 text-xs uppercase font-black tracking-wider">
                <tr>
                    <th scope="col" class="px-6 py-4 rounded-tl-xl">No</th>
                    <th scope="col" class="px-6 py-4">Tanggal</th>
                    <th scope="col" class="px-6 py-4">Tujuan</th>
                    <th scope="col" class="px-6 py-4">Jenis</th>
                    <th scope="col" class="px-6 py-4">Pelapor</th>
                    <th scope="col" class="px-6 py-4">Aduan</th>
                    <th scope="col" class="px-6 py-4">Lampiran</th>
                    <th scope="col" class="px-6 py-4 text-right rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($reports as $item)
                    <tr class="hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-slate-500">{{ $reports->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-slate-400">
                            {{ $item->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-500 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                {{ $item->bagian }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $jenisColors = ['KORUPSI' => 'text-red-400 bg-red-500/10 border-red-500/20', 'PUNGLI' => 'text-violet-400 bg-violet-500/10 border-violet-500/20', 'KESEWENANG' => 'text-pink-400 bg-pink-500/10 border-pink-500/20'];
                                $jc = $jenisColors[$item->jenis_laporan] ?? 'text-slate-400 bg-slate-500/10 border-slate-500/20';
                            @endphp
                            <span class="px-2 py-1 border rounded-lg text-[10px] font-black uppercase tracking-widest {{ $jc }}">
                                {{ $item->jenis_laporan ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-white">{{ $item->nama }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $item->nomor_hp }}</div>
                        </td>
                        <td class="px-6 py-4 min-w-[250px]">
                            <p class="text-xs text-slate-300 whitespace-normal line-clamp-3 leading-relaxed">
                                {{ $item->aduan }}
                            </p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($item->bukti_dukung)
                                <a href="{{ asset('storage/' . $item->bukti_dukung) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-primary/10 text-brand-primary border border-brand-primary/20 hover:bg-brand-primary hover:text-white rounded-lg text-xs font-bold transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> 
                                    Lihat File
                                </a>
                            @else
                                <span class="text-xs text-slate-500 italic">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <form action="{{ route('admin.bws.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors p-2 bg-slate-800 rounded-lg border border-slate-700 hover:border-red-500/50" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-500 font-medium">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                Belum ada data pengaduan masuk.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($reports->hasPages())
    <div class="px-6 py-4 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-[10px] font-bold text-slate-500">
            Menampilkan {{ $reports->firstItem() }} - {{ $reports->lastItem() }} dari {{ $reports->total() }} data
        </p>
        <div class="flex items-center gap-1">
            {{-- Previous --}}
            @if($reports->onFirstPage())
                <span class="px-3 py-2 bg-slate-800/50 text-slate-600 rounded-lg text-[10px] font-black cursor-not-allowed">&laquo;</span>
            @else
                <a href="{{ $reports->previousPageUrl() }}" class="px-3 py-2 bg-slate-800 text-white rounded-lg text-[10px] font-black hover:bg-brand-primary transition-colors">&laquo;</a>
            @endif

            @foreach($reports->getUrlRange(max(1, $reports->currentPage()-2), min($reports->lastPage(), $reports->currentPage()+2)) as $page => $url)
                <a href="{{ $url }}" class="px-3 py-2 rounded-lg text-[10px] font-black transition-colors {{ $page == $reports->currentPage() ? 'bg-brand-primary text-white shadow-lg' : 'bg-slate-800 text-slate-300 hover:bg-slate-700' }}">{{ $page }}</a>
            @endforeach

            {{-- Next --}}
            @if($reports->hasMorePages())
                <a href="{{ $reports->nextPageUrl() }}" class="px-3 py-2 bg-slate-800 text-white rounded-lg text-[10px] font-black hover:bg-brand-primary transition-colors">&raquo;</a>
            @else
                <span class="px-3 py-2 bg-slate-800/50 text-slate-600 rounded-lg text-[10px] font-black cursor-not-allowed">&raquo;</span>
            @endif
        </div>
    </div>
    @endif
</div>

<script>
    function previewBwsImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const outputExisting = document.getElementById('bws-preview');
            const outputFallback = document.getElementById('bws-preview-fallback');
            const placeholder = document.getElementById('bws-placeholder');
            
            if (outputExisting) outputExisting.src = reader.result;
            if (outputFallback) {
                outputFallback.src = reader.result;
                outputFallback.classList.remove('hidden');
            }
            if (placeholder) placeholder.classList.add('hidden');
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
