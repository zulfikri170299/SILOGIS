@extends('admin.layout')

@section('title', 'Edit Dokumen')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="space-y-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.documents.index') }}" class="h-12 w-12 rounded-2xl bg-slate-900 border border-white/5 flex items-center justify-center text-slate-400 hover:text-white transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
            </a>
            <div>
                <h2 class="text-2xl font-black text-white italic tracking-tight font-outfit uppercase">Edit Dokumen</h2>
                <p class="text-slate-400 text-sm font-medium uppercase tracking-widest mt-1">Perbarui informasi berkas publik</p>
            </div>
        </div>

        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-[2.5rem] border border-white/5 shadow-2xl overflow-hidden">
            <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data" class="p-8 md:p-12 space-y-10">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Judul Dokumen -->
                    <div class="space-y-3">
                        <label for="title" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 flex items-center gap-2">
                             JUDUL PUBLIKASI
                             <span class="text-red-500">*</span>
                        </label>
                        <input id="title" name="title" type="text" required value="{{ old('title', $document->title) }}"
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 px-6 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                            placeholder="Contoh: Dokumen Regulasi Satker 2024">
                        @error('title') <p class="text-xs text-rose-500 font-bold mt-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- Pilih Folder -->
                    <div class="space-y-3">
                        <label for="document_folder_id" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">PINDAHKAN KE FOLDER</label>
                        <select id="document_folder_id" name="document_folder_id"
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 px-6 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all appearance-none cursor-pointer">
                            <option value="">-- Tanpa Folder (Mandiri) --</option>
                            @foreach($folders as $folder)
                                <option value="{{ $folder->id }}" {{ old('document_folder_id', $document->document_folder_id) == $folder->id ? 'selected' : '' }}>
                                    {{ $folder->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Kategori -->
                    <div class="space-y-3">
                        <label for="category" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">TAG / LABEL KATEGORI</label>
                        <input id="category" name="category" type="text" value="{{ old('category', $document->category) }}"
                            class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 px-6 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold transition-all placeholder:text-slate-600"
                            placeholder="Contoh: Regulasi, Formulir, Laporan">
                    </div>
                </div>

                <!-- Input File -->
                <div class="space-y-3">
                    <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">BERKAS SAAT INI</label>
                    <div class="p-6 bg-slate-800/50 rounded-2xl border border-white/5 flex items-center justify-between">
                         <div class="flex items-center gap-4">
                            <div class="h-10 w-10 bg-brand-primary/10 rounded-xl flex items-center justify-center text-brand-primary">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <p class="text-xs font-black text-white italic truncate max-w-[200px]">{{ $document->original_filename }}</p>
                                <p class="text-[8px] font-bold uppercase tracking-widest text-slate-500">{{ $document->file_size }}</p>
                            </div>
                         </div>
                         <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="text-[9px] font-black text-brand-primary uppercase tracking-widest hover:text-white transition-colors">Lihat File</a>
                    </div>

                    <div class="pt-4">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 block mb-3 text-center md:text-left">GANTI BERKAS (OPSIONAL)</label>
                        <div class="relative">
                            <label class="flex flex-col items-center justify-center w-full h-32 bg-slate-800/20 rounded-[2rem] border-2 border-dashed border-white/10 hover:border-brand-primary/50 hover:bg-brand-primary/5 transition-all cursor-pointer group">
                                <div class="flex flex-col items-center justify-center pt-2 pb-3">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-white transition-colors">Pilih file baru atau seret ke sini</p>
                                    <p class="text-[8px] font-bold uppercase tracking-widest text-slate-600 mt-1">Maksimal 20MB</p>
                                </div>
                                <input type="file" name="file" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx" />
                            </label>
                        </div>
                        @error('file') <p class="text-xs text-rose-500 font-bold mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="space-y-3">
                    <label for="description" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500">DESKRIPSI SINGKAT</label>
                    <textarea id="description" name="description" rows="4" 
                        class="block w-full bg-slate-800/50 rounded-2xl border-white/5 py-4 px-6 text-white shadow-sm focus:border-brand-primary focus:ring-brand-primary sm:text-sm font-bold italic transition-all placeholder:text-slate-600"
                        placeholder="Berikan sedikit penjelasan mengenai isi dokumen...">{{ old('description', $document->description) }}</textarea>
                </div>

                <div class="pt-6 border-t border-white/5 flex justify-end">
                    <button type="submit" class="bg-brand-primary text-white px-12 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs shadow-2xl shadow-brand-primary/40 hover:scale-105 transition-all active:scale-[0.98] italic">
                        Perbarui Publikasi Berkas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
