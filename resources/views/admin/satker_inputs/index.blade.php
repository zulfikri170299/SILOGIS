@extends('admin.layout')

@section('title', 'Inputan ' . $bagian->name)

@section('content')
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight">Inputan {{ $bagian->name }}</h2>
        <p class="text-sm text-slate-400 mt-1">Daftar hasil inputan dari Satker ke {{ $bagian->name }}.</p>
    </div>
    @if(auth()->user()->role === 'admin_satker')
    <a href="{{ route('admin.satker_inputs.create', $bagian->id) }}" class="bg-gradient-to-r from-brand-primary to-indigo-600 px-6 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest text-white hover:shadow-[0_0_20px_rgba(0,98,255,0.4)] transition-all hover:scale-105 active:scale-95 whitespace-nowrap inline-flex items-center justify-center gap-2">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah Inputan
    </a>
    @endif
</div>

<div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="text-[10px] font-black uppercase tracking-widest text-slate-400 bg-white/5 border-b border-white/5">
                <tr>
                    <th class="px-6 py-4">Satker</th>
                    <th class="px-6 py-4">Judul</th>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4 text-center">Lampiran</th>
                    <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($inputs as $input)
                <tr class="hover:bg-white/5 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="font-bold text-white">{{ $input->satker->name ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-white">{{ $input->judul }}</div>
                        @if($input->deskripsi)
                        <div class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $input->deskripsi }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-xs font-medium">{{ $input->created_at->format('d M Y') }}</div>
                        <div class="text-[10px] text-slate-500">{{ $input->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($input->file_lampiran)
                            <a href="{{ Storage::url($input->file_lampiran) }}" target="_blank" class="text-brand-primary hover:text-indigo-400 transition-colors inline-flex flex-col items-center gap-1 group/btn">
                                <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                <span class="text-[9px] font-black uppercase tracking-widest">Lihat File</span>
                            </a>
                        @else
                            <span class="text-xs text-slate-500 italic">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if(auth()->user()->role === 'superadmin' || (auth()->user()->role === 'admin_satker' && auth()->user()->satker_id == $input->satker_id))
                        <form action="{{ route('admin.satker_inputs.destroy', $input->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus inputan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-400 hover:text-white hover:bg-red-500/20 rounded-lg transition-all" title="Hapus">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white/5 mb-4">
                            <svg class="w-8 h-8 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                        </div>
                        <p class="text-slate-400 text-sm font-medium">Belum ada hasil inputan di bagian ini.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
