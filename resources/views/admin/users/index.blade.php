@extends('admin.layout')

@section('title', 'Kelola Pengguna')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight">Katalog Pengguna</h2>
        <p class="text-[10px] text-slate-500 mt-2 font-black uppercase tracking-widest">Manajemen Akses Sistem</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-brand-primary to-indigo-600 px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest text-white hover:shadow-[0_0_20px_rgba(0,98,255,0.4)] transition-all hover:scale-105 active:scale-95">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah Pengguna
    </a>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-bold flex items-center gap-3">
    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-bold flex items-center gap-3">
    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    {{ session('error') }}
</div>
@endif

<div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/80 text-[10px] uppercase tracking-widest font-black text-slate-500 border-b border-white/5">
                <tr>
                    <th scope="col" class="px-6 py-5">Nama / Email</th>
                    <th scope="col" class="px-6 py-5">Role</th>
                    <th scope="col" class="px-6 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach ($users as $user)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-white">{{ $user->name }}</div>
                        <div class="text-xs text-slate-500 mt-1">{{ $user->email }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($user->role === 'superadmin')
                            <span class="px-3 py-1 rounded-full bg-purple-500/10 text-purple-400 text-xs font-black uppercase tracking-widest">Super Admin</span>
                        @elseif($user->role === 'admin_satker')
                            <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-xs font-black uppercase tracking-widest">Admin Satker</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-black uppercase tracking-widest">Admin Bagian: {{ $user->bagian->name ?? '-' }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('admin.users.edit', $user) }}" class="p-2 bg-white/5 rounded-xl text-slate-400 hover:text-white hover:bg-brand-primary transition-all group relative">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirmDelete(this, 'Hapus pengguna ini secara permanen?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-white/5 rounded-xl text-slate-400 hover:text-white hover:bg-red-500 transition-all group relative">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
