@extends('admin.layout')

@section('title', 'Kelola Bagian')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight">Katalog Bagian</h2>
        <p class="text-[10px] text-slate-500 mt-2 font-black uppercase tracking-widest">Manajemen Struktur Unit Kerja</p>
    </div>
    <a href="{{ route('admin.bagians.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-brand-primary to-indigo-600 px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest text-white hover:shadow-[0_0_20px_rgba(0,98,255,0.4)] transition-all hover:scale-105 active:scale-95">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah Bagian
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-bold flex items-center gap-3">
    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    {{ session('success') }}
</div>
@endif

<div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/80 text-[10px] uppercase tracking-widest font-black text-slate-500 border-b border-white/5">
                <tr>
                    <th scope="col" class="px-6 py-5">Nama Bagian</th>
                    <th scope="col" class="px-6 py-5">Jumlah Admin</th>
                    <th scope="col" class="px-6 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($bagians as $bagian)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4 font-bold text-white">{{ $bagian->name }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full bg-brand-primary/10 text-brand-primary text-xs font-black">{{ $bagian->users()->count() }} User</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.bagians.edit', $bagian) }}" class="p-2 bg-white/5 rounded-xl text-slate-400 hover:text-white hover:bg-brand-primary transition-all group relative">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </a>
                            <form action="{{ route('admin.bagians.destroy', $bagian) }}" method="POST" class="inline" onsubmit="return confirmDelete(this, 'Hapus bagian ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-white/5 rounded-xl text-slate-400 hover:text-white hover:bg-red-500 transition-all group relative">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 rounded-full bg-slate-800 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                            </div>
                            <p class="text-slate-400 font-bold">Katalog bagian masih kosong.</p>
                            <a href="{{ route('admin.bagians.create') }}" class="mt-4 text-brand-primary font-bold hover:underline">Tambahkan bagian baru</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
