@extends('admin.layout')

@section('title', 'Managemen Dokumen')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-white italic tracking-tight font-outfit uppercase">Repositori Dokumen</h2>
            <p class="text-slate-400 text-sm font-medium uppercase tracking-widest mt-1">Kelola berkas publik (PDF, Word, Excel)</p>
        </div>
        <a href="{{ route('admin.documents.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-brand-primary text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:scale-105 transition-all shadow-xl shadow-brand-primary/20 italic">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
            Unggah Dokumen Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border-l-4 border-emerald-500 p-4 rounded-r-xl">
            <p class="text-emerald-400 font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-slate-900/50 backdrop-blur-2xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/5 bg-slate-900/50">
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-500">Info File</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-500">Kategori</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-500">Ukuran</th>
                        <th class="px-8 py-6 text-[10px] font-black uppercase tracking-widest text-slate-500 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @forelse($documents as $doc)
                    <tr class="hover:bg-white/[0.02] transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-12 rounded-2xl bg-slate-800 flex items-center justify-center text-brand-primary shadow-inner border border-white/5">
                                    @if(in_array($doc->file_type, ['pdf']))
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                    @elseif(in_array($doc->file_type, ['doc', 'docx']))
                                        <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                    @else
                                        <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-black text-white italic tracking-tight">{{ $doc->title }}</p>
                                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">{{ $doc->original_filename }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-3 py-1 bg-brand-primary/10 text-brand-primary text-[9px] font-black uppercase tracking-widest rounded-full border border-brand-primary/20">
                                {{ $doc->category ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $doc->file_size }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.documents.edit', $doc) }}" class="p-2 bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white rounded-lg transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('admin.documents.destroy', $doc) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini secara permanen?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-rose-500/10 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center gap-4">
                                <div class="h-20 w-20 rounded-[2rem] bg-slate-800/50 flex items-center justify-center text-slate-600">
                                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                </div>
                                <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px]">Belum ada dokumen yang diunggah</p>
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
