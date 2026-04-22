@extends('admin.layout')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-900/50 backdrop-blur-2xl p-8 rounded-3xl border border-white/5 shadow-2xl">
        <div>
            <h2 class="text-xl font-black text-white tracking-tight font-outfit italic uppercase">Struktur Organisasi</h2>
            <p class="text-[10px] text-slate-500 mt-2 font-black uppercase tracking-widest">Manajemen Pimpinan & Anggota Logistik</p>
        </div>
        <a href="{{ route('admin.organograms.create') }}" class="w-full sm:w-auto bg-brand-primary text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-brand-primary/20 hover:scale-105 transition-all flex items-center justify-center gap-3 italic">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
            Tambah Anggota
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-2xl flex items-center gap-3 animate-in slide-in-from-top duration-300">
            <svg class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <p class="text-sm font-bold text-emerald-800">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-900 text-slate-500 border-b border-white/5">
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] w-20">Foto</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em]">Data Anggota</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em]">Atasan (Parent)</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em]">Urutan</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($organograms as $org)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-6">
                                <div class="h-12 w-12 rounded-[0.5rem] bg-slate-800 flex items-center justify-center overflow-hidden border border-white/10">
                                    @if($org->photo)
                                        <img src="{{ asset('storage/' . $org->photo) }}" class="h-full w-full object-cover" alt="Foto">
                                    @else
                                        <svg class="h-6 w-6 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="font-black text-white group-hover:text-brand-primary transition-colors font-outfit uppercase italic">{{ $org->position }}</div>
                                <div class="text-[9px] text-slate-400 mt-1 font-bold tracking-widest uppercase truncate">{{ $org->name }} - {{ $org->rank }}</div>
                            </td>
                            <td class="px-8 py-6 text-slate-400 text-xs font-medium">
                                @if($org->parent)
                                    {{ $org->parent->position }} ({{ $org->parent->name }})
                                @else
                                    <span class="text-brand-primary font-bold italic">Top Level</span>
                                @endif
                            </td>
                            <td class="px-8 py-6 text-white text-xs font-bold">
                                {{ $org->order }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.organograms.edit', $org) }}" class="p-2.5 rounded-xl bg-slate-800 text-slate-400 hover:bg-brand-primary hover:text-white transition-all shadow-lg">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('admin.organograms.destroy', $org) }}" method="POST" class="inline" onsubmit="return confirm('Hapus struktur ini dari sistem? Semua bawahan mungkin akan kehilangan parentnya.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 rounded-xl bg-slate-800 text-slate-400 hover:bg-rose-600 hover:text-white transition-all shadow-lg">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <p class="text-slate-400 font-bold">Struktur belum ditambahkan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
