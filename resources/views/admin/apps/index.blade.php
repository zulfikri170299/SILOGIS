@extends('admin.layout')

@section('title', 'Katalog Aplikasi')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-900/50 backdrop-blur-2xl p-8 rounded-3xl border border-white/5 shadow-2xl">
        <div>
            <h2 class="text-xl font-black text-white tracking-tight font-outfit italic uppercase">Katalog Ekosistem Digital</h2>
            <p class="text-[10px] text-slate-500 mt-2 font-black uppercase tracking-widest">Manajemen Tautan Operasional & Aplikasi Strategis</p>
        </div>
        <a href="{{ route('admin.apps.create') }}" class="w-full sm:w-auto bg-brand-primary text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-xl shadow-brand-primary/20 hover:scale-105 transition-all flex items-center justify-center gap-3 italic">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
            Registrasi Aplikasi
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
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em]">Application Asset</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em]">Domain Class</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-center">Visual ID</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-right">Protocol</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse ($apps as $app)
                        <tr class="hover:bg-white/[0.02] transition-colors group">
                            <td class="px-8 py-6">
                                <div class="font-black text-white group-hover:text-brand-primary transition-colors font-outfit uppercase italic">{{ $app->title }}</div>
                                <div class="text-[9px] text-slate-500 mt-1 font-bold tracking-widest uppercase truncate max-w-xs">{{ $app->url }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest bg-slate-800 text-slate-400 border border-white/5">
                                    {{ $app->category ?? 'General' }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-center">
                                    @if($app->icon)
                                        <div class="h-12 w-12 rounded-xl bg-white p-1.5 border border-white/10 shadow-2xl transition-transform group-hover:scale-110">
                                            <img src="{{ asset('storage/' . $app->icon) }}" class="h-full w-full object-contain" alt="">
                                        </div>
                                    @else
                                        <div class="h-12 w-12 rounded-xl bg-slate-800 border border-white/5 flex items-center justify-center text-slate-600">
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.apps.edit', $app) }}" class="p-2.5 rounded-xl bg-slate-800 text-slate-400 hover:bg-brand-primary hover:text-white transition-all shadow-lg">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('admin.apps.destroy', $app) }}" method="POST" class="inline" onsubmit="return confirm('Hapus aplikasi ini dari sistem?');">
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
                            <td colspan="4" class="px-6 py-20 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="h-16 w-16 text-slate-200 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    <p class="text-slate-400 font-bold">Katalog aplikasi masih kosong.</p>
                                    <a href="{{ route('admin.apps.create') }}" class="mt-4 text-indigo-600 font-bold hover:underline">Daftarkan aplikasi pertama Anda</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
