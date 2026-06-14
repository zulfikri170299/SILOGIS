@extends('admin.layout')

@section('title', 'Kelola Metode Pengadaan')

@section('content')
<div class="mb-8 flex justify-between items-center" x-data="{ createModalOpen: false, editModalOpen: false, selectedData: {} }">
    <div>
        <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight">Metode Pengadaan</h2>
        <p class="text-[10px] text-slate-500 mt-2 font-black uppercase tracking-widest">Master Data Metode Pengadaan</p>
    </div>
    <button @click="createModalOpen = true" class="flex items-center gap-2 bg-gradient-to-r from-brand-primary to-indigo-600 px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest text-white hover:shadow-[0_0_20px_rgba(0,98,255,0.4)] transition-all hover:scale-105 active:scale-95">
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
        Tambah Data
    </button>

    <!-- Create Modal -->
    <template x-teleport="body">
        <div x-show="createModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="createModalOpen" @click="createModalOpen = false" class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="createModalOpen" class="inline-block p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-slate-800 border border-white/10 shadow-2xl rounded-2xl w-full max-w-md">
                    <h3 class="text-lg font-black text-white uppercase tracking-wider mb-4">Tambah Metode Pengadaan</h3>
                    <form action="{{ route('admin.master-metode.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-400 mb-2">Nama Metode (Contoh: E-PURCHASING, TENDER)</label>
                            <input type="text" name="nama_metode" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary transition-all">
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="createModalOpen = false" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:bg-white/5 transition-colors">Batal</button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-brand-primary text-white hover:bg-blue-600 transition-colors shadow-lg shadow-brand-primary/30">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    <!-- Edit Modal -->
    <template x-teleport="body">
        <div x-show="editModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="editModalOpen" @click="editModalOpen = false" class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="editModalOpen" class="inline-block p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-slate-800 border border-white/10 shadow-2xl rounded-2xl w-full max-w-md">
                    <h3 class="text-lg font-black text-white uppercase tracking-wider mb-4">Edit Metode Pengadaan</h3>
                    <form :action="`/admin/master-metode/${selectedData.id}`" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-400 mb-2">Nama Metode</label>
                            <input type="text" name="nama_metode" x-model="selectedData.nama_metode" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary transition-all">
                        </div>
                        <div class="flex justify-end gap-3 mt-6">
                            <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:bg-white/5 transition-colors">Batal</button>
                            <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-brand-primary text-white hover:bg-blue-600 transition-colors shadow-lg shadow-brand-primary/30">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>

@if(session('success'))
<div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-bold flex items-center gap-3">
    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm font-bold">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden" x-data="{ editModalOpen: false, selectedData: {} }">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="bg-slate-900/80 text-[10px] uppercase tracking-widest font-black text-slate-500 border-b border-white/5">
                <tr>
                    <th scope="col" class="px-6 py-5 w-16">No</th>
                    <th scope="col" class="px-6 py-5">Nama Metode</th>
                    <th scope="col" class="px-6 py-5 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse ($metodes as $item)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4 text-xs font-bold text-slate-500">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-bold text-white">{{ $item->nama_metode }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <button type="button" @click="$dispatch('open-edit', {{ json_encode($item) }})" class="p-2 bg-white/5 rounded-xl text-slate-400 hover:text-white hover:bg-brand-primary transition-all group relative">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                            </button>
                            <form action="{{ route('admin.master-metode.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirmDelete(this, 'Hapus data ini secara permanen?');">
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
                        <p class="text-slate-400 font-bold">Data Master Metode Pengadaan masih kosong.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        window.addEventListener('open-edit', (e) => {
            const container = document.querySelector('[x-data="{ createModalOpen: false, editModalOpen: false, selectedData: {} }"]');
            if(container && container.__x) {
                container.__x.$data.selectedData = e.detail;
                container.__x.$data.editModalOpen = true;
            }
        });
    });
</script>
@endsection
