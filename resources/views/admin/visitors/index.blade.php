@extends('admin.layout')

@section('title', 'Rekap Pengunjung')

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:justify-between md:items-end gap-4">
    <div>
        <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight">Rekap Pengunjung</h2>
        <p class="text-[10px] text-slate-500 mt-2 font-black uppercase tracking-widest">Total Pengunjung Unik: {{ $visitors->total() }}</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <form action="{{ route('admin.visitors.index') }}" method="GET" class="relative w-full sm:w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengunjung..." 
                   class="w-full bg-slate-900/50 border border-white/10 text-white text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all placeholder:text-slate-500">
            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </button>
        </form>
        <a href="{{ route('admin.visitors.print', ['search' => request('search')]) }}" target="_blank"
           class="flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs uppercase tracking-widest px-5 py-2.5 rounded-xl transition-all shadow-lg shadow-blue-500/20">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            Cetak PDF
        </a>
    </div>
</div>

<div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/80 text-[10px] uppercase tracking-widest font-black text-slate-500 border-b border-white/5">
                <tr>
                    <th scope="col" class="px-6 py-5">No</th>
                    <th scope="col" class="px-6 py-5">Nama</th>
                    <th scope="col" class="px-6 py-5">Satuan Kerja</th>
                    <th scope="col" class="px-6 py-5 hidden md:table-cell">Total Kunjungan</th>
                    <th scope="col" class="px-6 py-5 hidden md:table-cell">Terakhir Kunjung</th>
                    <th scope="col" class="px-6 py-5 md:hidden text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($visitors as $index => $visitor)
                @php
                    $terakhirKunjung = $visitor->logs->isNotEmpty() 
                        ? \Carbon\Carbon::parse($visitor->logs->first()->visited_at)->translatedFormat('d M Y, H:i') 
                        : \Carbon\Carbon::parse($visitor->created_at)->translatedFormat('d M Y, H:i');
                    $komputerCount = $visitor->logs->where('device', 'Komputer')->count();
                    $handphoneCount = $visitor->logs->where('device', 'Handphone')->count();
                    $perangkatInfo = '';
                    if($komputerCount > 0) $perangkatInfo .= 'Komputer: ' . $komputerCount . ' kali ';
                    if($handphoneCount > 0) $perangkatInfo .= 'Handphone: ' . $handphoneCount . ' kali';
                @endphp
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4">{{ $visitors->firstItem() + $index }}</td>
                    <td class="px-6 py-4 font-bold text-white">{{ $visitor->nama }}</td>
                    <td class="px-6 py-4 text-slate-400">{{ $visitor->satuan_kerja ?? '-' }}</td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs font-black uppercase tracking-widest">{{ $visitor->logs_count }} kali</span>
                    </td>
                    <td class="px-6 py-4 text-slate-400 hidden md:table-cell">
                        {{ $terakhirKunjung }}
                    </td>
                    <td class="px-6 py-4 text-right md:hidden">
                        <button @click="$dispatch('open-visitor-detail', { nama: '{{ addslashes($visitor->nama) }}', email: '{{ addslashes($visitor->email) }}', satker: '{{ addslashes($visitor->satuan_kerja ?? '-') }}', kunjungan: '{{ $visitor->logs_count }} kali', terakhir: '{{ $terakhirKunjung }}', perangkat: '{{ $perangkatInfo }}' })" 
                                class="p-2 bg-blue-500/10 text-blue-400 rounded-xl hover:bg-blue-500 hover:text-white transition-colors shadow-lg shadow-blue-500/10" title="Lihat Detail">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-slate-500 text-sm">
                        Belum ada data pengunjung.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($visitors->hasPages())
    <div class="p-6 border-t border-white/5">
        {{ $visitors->links() }}
    </div>
    @endif
</div>

@push('modals')
<div x-data="{ detailModalOpen: false, detail: {} }" @open-visitor-detail.window="detail = $event.detail; detailModalOpen = true">
    <!-- Mobile Detail Modal -->
    <div x-show="detailModalOpen" x-cloak class="fixed inset-0 z-[99999] flex items-end sm:items-center justify-center p-4 bg-[#0f172a]/90 backdrop-blur-sm md:hidden" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-slate-900 border border-white/10 rounded-3xl p-6 w-full max-w-sm relative shadow-2xl overflow-y-auto max-h-[85vh]" @click.away="detailModalOpen = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95">
            <button @click="detailModalOpen = false" class="absolute top-4 right-4 text-slate-400 hover:text-white transition-colors bg-white/5 hover:bg-white/10 p-2 rounded-full">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <div class="mb-6 border-b border-white/5 pb-4 pr-8">
                <h3 class="text-lg font-black text-white uppercase font-outfit tracking-wider">Detail Pengunjung</h3>
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-1" x-text="detail.nama"></p>
            </div>
            
            <div class="space-y-5">
                <div>
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Satuan Kerja</label>
                    <div class="text-sm text-slate-200 font-medium break-words" x-text="detail.satker"></div>
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Total Kunjungan</label>
                    <div class="inline-block px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs font-black uppercase tracking-widest" x-text="detail.kunjungan"></div>
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Terakhir Kunjung</label>
                    <div class="text-sm text-slate-200 font-medium" x-text="detail.terakhir"></div>
                </div>
                <div>
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1.5">Perangkat yang Digunakan</label>
                    <div class="text-sm text-slate-200 font-medium" x-text="detail.perangkat"></div>
                </div>
            </div>
            
            <button @click="detailModalOpen = false" class="w-full mt-8 py-4 bg-slate-800 hover:bg-slate-700 text-white font-black uppercase text-[10px] tracking-widest rounded-xl transition-all border border-white/5">
                Tutup Kembali
            </button>
        </div>
    </div>
</div>
@endpush
@endsection
