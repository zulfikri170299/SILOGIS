@extends('admin.layout')

@section('title', 'Managemen Folder Dokumen')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-black text-white italic tracking-tight font-outfit uppercase">Folder Dokumen</h2>
            <p class="text-slate-400 text-sm font-medium uppercase tracking-widest mt-1">Kelola pengelompokan berkas publik</p>
        </div>
        <a href="{{ route('admin.document-folders.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-brand-primary text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:scale-105 transition-all shadow-xl shadow-brand-primary/20 italic">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" /></svg>
            Buat Folder Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-500/10 border-l-4 border-emerald-500 p-4 rounded-r-xl">
            <p class="text-emerald-400 font-bold text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($folders as $folder)
        <div class="group bg-slate-900/50 backdrop-blur-2xl rounded-[2.5rem] p-8 border border-white/5 hover:border-brand-primary transition-all duration-500">
            <div class="flex items-start justify-between mb-8">
                <div class="h-16 w-16 bg-slate-800 rounded-2xl flex items-center justify-center text-amber-500 shadow-inner group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition-all duration-500">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
                </div>
                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="{{ route('admin.document-folders.edit', $folder) }}" class="p-2 bg-amber-500/10 text-amber-500 hover:bg-amber-500 hover:text-white rounded-lg transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </a>
                    <form action="{{ route('admin.document-folders.destroy', $folder) }}" method="POST" onsubmit="return confirm('Hapus folder ini? Dokumen di dalamnya tidak akan terhapus namun akan kehilangan kelompok foldernya.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 bg-rose-500/10 text-rose-500 hover:bg-rose-500 hover:text-white rounded-lg transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                </div>
            </div>

            <div class="space-y-2">
                <h3 class="text-xl font-black text-white italic font-outfit uppercase tracking-tight group-hover:text-amber-500 transition-colors">{{ $folder->name }}</h3>
                <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">{{ $folder->documents_count }} Berkas Terdata</p>
                @if($folder->description)
                <p class="text-slate-400 text-[11px] leading-relaxed mt-4 line-clamp-2 italic font-medium">{{ $folder->description }}</p>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 bg-slate-900/50 rounded-[3rem] border border-dashed border-white/5 flex flex-col items-center justify-center text-center">
             <div class="h-20 w-20 bg-slate-800 rounded-3xl shadow-inner flex items-center justify-center text-slate-600 mb-6 font-bold">
                <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
             </div>
             <h4 class="text-lg font-black text-slate-500 uppercase tracking-widest italic font-outfit">Belum Ada Folder</h4>
             <p class="text-xs text-slate-600 mt-2 font-bold uppercase tracking-widest">Buat folder pertama untuk merapikan repositori dokumen.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
