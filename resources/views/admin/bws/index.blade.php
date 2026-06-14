@extends('admin.layout')
@section('title', 'Daftar Pengaduan WBS')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl sm:text-2xl font-black text-white uppercase tracking-tight">Pengaduan WBS</h2>
        <p class="text-xs sm:text-sm text-slate-400 mt-1">Kelola masuknya data Biro Logistik Whistleblowing System.</p>
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
        @if(!Auth::user()->isAdminBag())
        <!-- Bagian Filter -->
        <div class="flex-1 min-w-0">
            <label class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-1.5">Bagian</label>
            <select name="bagian" class="w-full bg-slate-800 border border-white/10 rounded-xl text-white text-xs font-bold py-2.5 px-3 focus:border-brand-primary focus:ring-brand-primary">
                <option value="">Semua Bagian</option>
                @foreach($bagians as $bag)
                    <option value="{{ $bag }}" {{ request('bagian') == $bag ? 'selected' : '' }}>{{ $bag }}</option>
                @endforeach
            </select>
        </div>
        @endif
        <!-- Jenis Laporan Filter -->
        <div class="flex-1 min-w-0">
            <label class="text-[9px] font-black uppercase tracking-widest text-slate-500 block mb-1.5">Jenis</label>
            <select name="jenis_laporan" class="w-full bg-slate-800 border border-white/10 rounded-xl text-white text-xs font-bold py-2.5 px-3 focus:border-brand-primary focus:ring-brand-primary">
                <option value="">Semua Jenis</option>
                @foreach(['KORUPSI KOLUSI DAN NEPOTISME','PUNGUTAN LIAR','PENYALAHGUNAAN WEWENANG','PENYALAHGUNAAN NARKOBA','LAINNYA'] as $jenis)
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

<!-- Table Wrapper with Alpine x-data -->
<div x-data="{ detailModalOpen: false, selectedItem: null }" @open-detail.window="selectedItem = $event.detail; detailModalOpen = true">
    <!-- Data Table -->
    <div class="bg-slate-900 border border-white/5 rounded-2xl shadow-xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-800 text-slate-100 text-xs uppercase font-black tracking-wider">
                <tr>
                    <th scope="col" class="px-4 py-4 sm:px-6 rounded-tl-xl w-10">No</th>
                    <th scope="col" class="px-2 py-4 sm:px-6 w-24 sm:w-auto">Tanggal</th>
                    <th scope="col" class="px-4 py-4 sm:px-6">Tujuan</th>
                    <th scope="col" class="px-6 py-4 hidden md:table-cell">Jenis</th>
                    <th scope="col" class="px-6 py-4 hidden lg:table-cell">Aduan</th>
                    <th scope="col" class="px-6 py-4 hidden md:table-cell">Lampiran</th>
                    <th scope="col" class="px-4 py-4 sm:px-6 text-right rounded-tr-xl">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse($reports as $item)
                    <tr class="hover:bg-slate-800/30 transition-colors">
                        <td class="px-4 py-4 sm:px-6 whitespace-nowrap text-xs font-bold text-slate-500">{{ $reports->firstItem() + $loop->index }}</td>
                        <td class="px-2 py-4 sm:px-6 whitespace-nowrap text-[10px] sm:text-xs font-bold text-slate-400">
                            {{ $item->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-4 py-4 sm:px-6 whitespace-nowrap">
                            <span class="px-2 py-1 bg-amber-500/10 border border-amber-500/20 text-amber-500 rounded-lg text-[10px] font-black uppercase tracking-widest">
                                {{ $item->bagian }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                            @php
                                $jenisColors = [
                                    'KORUPSI KOLUSI DAN NEPOTISME' => 'text-red-400 bg-red-500/10 border-red-500/20', 
                                    'PUNGUTAN LIAR' => 'text-purple-400 bg-purple-500/10 border-purple-500/20', 
                                    'PENYALAHGUNAAN WEWENANG' => 'text-pink-400 bg-pink-500/10 border-pink-500/20',
                                    'PENYALAHGUNAAN NARKOBA' => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
                                    'LAINNYA' => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20'
                                ];
                                $jc = $jenisColors[$item->jenis_laporan] ?? 'text-slate-400 bg-slate-500/10 border-slate-500/20';
                            @endphp
                            <span class="px-2 py-1 border rounded-lg text-[10px] font-black uppercase tracking-widest {{ $jc }}">
                                {{ $item->jenis_laporan ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 min-w-[250px] hidden lg:table-cell">
                            <p class="text-xs text-slate-300 whitespace-normal line-clamp-3 leading-relaxed">
                                {{ $item->aduan }}
                            </p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap space-y-2 hidden md:table-cell">
                            @if($item->bukti_dukung)
                                <div>
                                    <a href="{{ asset('storage/' . $item->bukti_dukung) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-brand-primary/10 text-brand-primary border border-brand-primary/20 hover:bg-brand-primary hover:text-white rounded-lg text-[10px] font-bold transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> 
                                        Bukti Pendukung 1
                                    </a>
                                </div>
                            @else
                                <div><span class="text-xs text-slate-500 italic">-</span></div>
                            @endif
                            
                            @if($item->bukti_dukung_tambahan)
                                <div>
                                    <a href="{{ asset('storage/' . $item->bukti_dukung_tambahan) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white rounded-lg text-[10px] font-bold transition-colors">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> 
                                        Bukti Tambahan
                                    </a>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-4 sm:px-6 text-right whitespace-nowrap">
                            <button type="button" @click="$dispatch('open-detail', {{ json_encode($item) }})" class="text-slate-400 hover:text-blue-500 transition-colors p-2 bg-slate-800 rounded-lg border border-slate-700 hover:border-blue-500/50 mr-1 md:hidden" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                            @if(Auth::user()->isSuperAdmin())
                            <form action="{{ route('admin.bws.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors p-2 bg-slate-800 rounded-lg border border-slate-700 hover:border-red-500/50" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                            @endif
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

    <!-- Modal Detail -->
    <div x-show="detailModalOpen" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 py-4 text-center">
            <!-- Background overlay -->
            <div x-show="detailModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity bg-slate-900/90" aria-hidden="true" @click="detailModalOpen = false"></div>

            <!-- Modal panel -->
            <div x-show="detailModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="relative z-10 w-full max-w-2xl p-6 overflow-hidden text-left align-middle transition-all transform bg-slate-800 border border-white/10 shadow-2xl rounded-2xl">
                
                <div class="flex justify-between items-start mb-5">
                    <h3 class="text-lg font-black text-white uppercase tracking-tight" id="modal-title">Detail Pengaduan WBS</h3>
                    <button @click="detailModalOpen = false" class="text-slate-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tanggal</p>
                            <p class="text-sm text-white font-medium" x-text="selectedItem ? String(selectedItem.created_at).substring(0, 19).replace('T', ' ') : ''"></p>
                        </div>
                        <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Tujuan Bagian</p>
                            <p class="text-sm text-amber-500 font-bold" x-text="selectedItem ? selectedItem.bagian : ''"></p>
                        </div>
                    </div>
                    
                    <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-1">Jenis Laporan</p>
                        <p class="text-sm text-white font-medium" x-text="selectedItem ? (selectedItem.jenis_laporan || '-') : ''"></p>
                    </div>
                    
                    <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Isi Aduan</p>
                        <p class="text-sm text-slate-300 leading-relaxed whitespace-pre-wrap" x-text="selectedItem ? selectedItem.aduan : ''"></p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Bukti Pendukung 1</p>
                            <template x-if="selectedItem && selectedItem.bukti_dukung">
                                <a :href="'/storage/' + selectedItem.bukti_dukung" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 bg-brand-primary/10 text-brand-primary border border-brand-primary/20 hover:bg-brand-primary hover:text-white rounded-lg text-[10px] font-bold transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> 
                                    Lihat Lampiran
                                </a>
                            </template>
                            <template x-if="!selectedItem || !selectedItem.bukti_dukung">
                                <p class="text-xs text-slate-500 italic">Tidak ada lampiran</p>
                            </template>
                        </div>
                        <div class="bg-slate-900/50 p-4 rounded-xl border border-white/5">
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Bukti Tambahan</p>
                            <template x-if="selectedItem && selectedItem.bukti_dukung_tambahan">
                                <a :href="'/storage/' + selectedItem.bukti_dukung_tambahan" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 hover:bg-emerald-500 hover:text-white rounded-lg text-[10px] font-bold transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg> 
                                    Lihat Lampiran
                                </a>
                            </template>
                            <template x-if="!selectedItem || !selectedItem.bukti_dukung_tambahan">
                                <p class="text-xs text-slate-500 italic">Tidak ada lampiran</p>
                            </template>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button @click="detailModalOpen = false" type="button" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-xl text-xs font-black uppercase tracking-widest transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
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
