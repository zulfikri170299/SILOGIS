@extends('admin.layout')

@section('title', 'Data Pengadaan Bag Ada')

@section('content')
<div @open-edit.window="selectedData = $event.detail; editModalOpen = true" x-data="{ 
    createModalOpen: false, 
    editModalOpen: false, 
    importModalOpen: {{ $errors->has('file_excel') ? 'true' : 'false' }}, 
    selectedData: {}, 
    selectedIds: [], 
    selectAll: false,
    isValidating: false,
    validationResult: null,
    unmatched: {},
    options: {},
    tempPath: '',
    validateExcel(e) {
        let file = e.target.files[0];
        if(!file) return;
        this.isValidating = true;
        this.validationResult = null;
        let formData = new FormData();
        formData.append('file_excel', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        fetch('{{ route('admin.bag-ada-inputs.import-validate', [], false) }}', {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json' }
        })
        .then(async res => {
            if (!res.ok) {
                // Try to parse error message if any
                let errMsg = 'Terjadi kesalahan pada server (HTTP ' + res.status + ').';
                try {
                    const errData = await res.json();
                    if (errData.message) errMsg = errData.message;
                } catch(e) {
                    if (res.status === 413) errMsg = 'Ukuran file terlalu besar. (Payload Too Large)';
                }
                throw new Error(errMsg);
            }
            return res.json();
        })
        .then(data => {
            this.isValidating = false;
            if(data.status === 'ok') {
                this.validationResult = 'ok';
                this.tempPath = data.path;
            } else if(data.status === 'mapping_required') {
                this.validationResult = 'mapping_required';
                this.tempPath = data.path;
                this.unmatched = data.unmatched;
                this.options = data.options;
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: data.message || 'Terjadi kesalahan.',
                    background: '#0f172a',
                    color: '#f8fafc'
                });
                e.target.value = '';
            }
        })
        .catch(err => {
            this.isValidating = false;
            console.error('Fetch Error:', err);
            let errorMessage = err.message || 'Gagal menghubungi server.';
            if (errorMessage.includes('Unexpected token')) {
                errorMessage = 'Sistem menerima format data yang tidak sesuai dari server (Bukan JSON). Ini biasanya disebabkan oleh ukuran file terlalu besar atau sesi telah berakhir.';
            }
            Swal.fire({
                icon: 'error',
                title: 'Gagal Memproses',
                text: errorMessage,
                background: '#0f172a',
                color: '#f8fafc'
            });
            e.target.value = '';
        });
    }
}"
     @open-import.window="importModalOpen = true; validationResult = null; tempPath = '';">
    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight">Data Pengadaan</h2>
            <p class="text-[10px] text-slate-500 mt-2 font-black uppercase tracking-widest">Pelaku Pengadaan & Paket Berkontrak</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Filter Tahun di Header -->
            <form action="{{ route('admin.bag-ada-inputs.index') }}" method="GET" class="flex items-center shrink-0">
                @if(request('satker_id'))
                    <input type="hidden" name="satker_id" value="{{ request('satker_id') }}">
                @endif
                @if(request('pelaku_pengadaan_id'))
                    <input type="hidden" name="pelaku_pengadaan_id" value="{{ request('pelaku_pengadaan_id') }}">
                @endif
                <select name="tahun" onchange="this.form.submit()" class="bg-slate-900 border border-white/10 rounded-full px-4 py-3 text-[10px] font-black uppercase tracking-widest text-white focus:border-brand-primary cursor-pointer hover:bg-slate-800 transition-colors appearance-none pr-8 relative">
                    @foreach($availableYears as $y)
                        <option value="{{ $y }}" {{ request('tahun', date('Y')) == $y ? 'selected' : '' }}>TAHUN {{ $y }}</option>
                    @endforeach
                </select>
                <!-- Custom Arrow Icon for Select -->
                <div class="pointer-events-none -ml-6 text-white/50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </div>
            </form>

            <button type="button" @click="$dispatch('open-import')" class="flex items-center gap-2 bg-blue-500/20 text-blue-400 px-4 py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-blue-500 hover:text-white transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                Import Data
            </button>
            <a href="{{ route('admin.bag-ada-inputs.export', request()->all()) }}" class="flex items-center gap-2 bg-emerald-500/20 text-emerald-400 px-4 py-3 rounded-full text-[10px] font-black uppercase tracking-widest hover:bg-emerald-500 hover:text-white transition-all shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export Excel
            </a>
            <button @click="createModalOpen = true" class="flex items-center gap-2 bg-gradient-to-r from-brand-primary to-indigo-600 px-6 py-3 rounded-full text-[10px] font-black uppercase tracking-widest text-white hover:shadow-[0_0_20px_rgba(0,98,255,0.4)] transition-all hover:scale-105 active:scale-95 shrink-0">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                Tambah Data
            </button>
        </div>
    </div>

    <!-- Filter Form & Rekapan -->
    <div class="mb-6 bg-slate-900/50 backdrop-blur-2xl p-4 rounded-2xl border border-white/5 flex flex-col xl:flex-row justify-between items-center gap-6 shadow-lg">
        <form action="{{ route('admin.bag-ada-inputs.index') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full xl:w-auto">
            <input type="hidden" name="tahun" value="{{ request('tahun', date('Y')) }}">
            
            @if(!Auth::user()->isAdminSatker())
            <select name="satker_id" class="w-full md:w-auto bg-slate-900 border border-white/10 rounded-xl px-4 py-2 text-xs text-white focus:border-brand-primary">
                <option value="">Semua Satker</option>
                @foreach($satkers as $s)
                    <option value="{{ $s->id }}" {{ request('satker_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            @endif
            
            <select name="pelaku_pengadaan_id" class="w-full md:w-auto bg-slate-900 border border-white/10 rounded-xl px-4 py-2 text-xs text-white focus:border-brand-primary">
                <option value="">Semua Pelaku Pengadaan</option>
                @foreach($pelakus as $p)
                    <option value="{{ $p->id }}" {{ request('pelaku_pengadaan_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_peran }}</option>
                @endforeach
            </select>

            <button type="submit" class="w-full md:w-auto bg-white/10 text-white px-4 py-2 rounded-xl text-xs font-bold hover:bg-white/20 transition-colors">
                Filter
            </button>
            @if(request()->anyFilled(['satker_id', 'pelaku_pengadaan_id']))
            <a href="{{ route('admin.bag-ada-inputs.index') }}" class="w-full md:w-auto text-center text-slate-400 hover:text-white text-xs font-bold px-4 py-2">
                Reset
            </a>
            @endif
        </form>

        <!-- Rekapan Pelaku Pengadaan -->
        <div class="flex flex-wrap justify-start xl:justify-end gap-3 w-full xl:w-auto">
            @foreach($rekapanPelaku as $peran => $jumlah)
                <div class="bg-slate-900/60 border border-white/10 px-4 py-2 rounded-xl flex items-center gap-3 shrink-0 shadow-sm">
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $peran }}</span>
                    <span class="text-base font-black text-white">{{ $jumlah }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bulk Action (muncul saat ada checkbox dicentang) -->
    <div x-show="selectedIds.length > 0" x-cloak style="display: none;" class="mb-6 flex items-center gap-3 bg-red-500/10 px-4 py-3 rounded-2xl border border-red-500/20 shadow-lg">
        <span class="text-xs font-bold text-red-400" x-text="selectedIds.length + ' data dipilih'"></span>
        <form action="{{ route('admin.bag-ada-inputs.bulk-destroy') }}" method="POST" class="ml-auto" onsubmit="return confirmDelete(this, 'Hapus semua data yang dipilih?');">
            @csrf
            @method('DELETE')
            <template x-for="id in selectedIds" :key="id">
                <input type="hidden" name="ids[]" :value="id">
            </template>
            <button type="submit" class="text-xs font-black bg-red-500 text-white px-4 py-2 rounded-xl hover:bg-red-600 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                Hapus Terpilih
            </button>
        </form>
    </div>

    <!-- Create Modal -->
    <template x-teleport="body">
        <div x-show="createModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="createModalOpen" @click="createModalOpen = false" class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="createModalOpen" class="inline-block p-6 my-8 text-left align-middle transition-all transform bg-slate-800 border border-white/10 shadow-2xl rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                    <h3 class="text-lg font-black text-white uppercase tracking-wider mb-6 pb-4 border-b border-white/10">Tambah Data Pengadaan</h3>
                    <form action="{{ route('admin.bag-ada-inputs.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if(!Auth::user()->isAdminSatker())
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-xs font-bold text-slate-400 mb-2">Pilih Satker</label>
                                <select name="satker_id" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                                    <option value="">-- Pilih Satker --</option>
                                    @foreach($satkers as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Pelaku Pengadaan</label>
                                <select name="pelaku_pengadaan_id" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                                    <option value="">-- Pilih Peran --</option>
                                    @foreach($pelakus as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama_peran }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Pangkat</label>
                                <input type="text" name="pangkat" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">NRP / NIP</label>
                                <input type="text" name="nrp_nip" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                            </div>

                            <div class="col-span-1 md:col-span-2 bg-slate-900/50 p-4 rounded-xl border border-white/5 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <h4 class="col-span-1 md:col-span-2 text-xs font-black text-amber-500 uppercase tracking-widest">KEP / SPRIN</h4>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Nomor KEP/SPRIN</label>
                                    <input type="text" name="kep_nomor" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Tanggal KEP/SPRIN</label>
                                    <input type="date" name="kep_tanggal" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-xs font-bold text-slate-400 mb-2">Menangani Paket</label>
                                <input type="text" name="menangani_paket" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white">
                            </div>

                            <div class="col-span-1 md:col-span-2 bg-slate-900/50 p-4 rounded-xl border border-white/5 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <h4 class="col-span-1 md:col-span-2 text-xs font-black text-emerald-500 uppercase tracking-widest">Nilai</h4>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Nilai Pagu (Rp)</label>
                                    <input type="number" name="nilai_pagu" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Nilai Kontrak (Rp)</label>
                                    <input type="number" name="nilai_kontrak" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Metode Pengadaan</label>
                                <select name="metode_pengadaan_id" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary">
                                    <option value="">-- Pilih Metode --</option>
                                    @foreach($metodes as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama_metode }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Nama Penyedia</label>
                                <input type="text" name="nama_penyedia" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white">
                            </div>

                            <div class="col-span-1 md:col-span-2 bg-slate-900/50 p-4 rounded-xl border border-white/5 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <h4 class="col-span-1 md:col-span-3 text-xs font-black text-blue-500 uppercase tracking-widest">Kontrak</h4>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Nomor Kontrak</label>
                                    <input type="text" name="kontrak_nomor" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Tanggal Mulai</label>
                                    <input type="date" name="kontrak_tanggal_mulai" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Tanggal Selesai</label>
                                    <input type="date" name="kontrak_tanggal_selesai" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-xs font-bold text-slate-400 mb-2">Keterangan</label>
                                <textarea name="keterangan" rows="2" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-white/10">
                            <button type="button" @click="createModalOpen = false" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:bg-white/5 transition-colors">Batal</button>
                            <button type="submit" class="px-8 py-2.5 rounded-xl text-xs font-bold bg-brand-primary text-white hover:bg-blue-600 transition-colors shadow-lg shadow-brand-primary/30">Simpan Data</button>
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
                <div x-show="editModalOpen" class="inline-block p-6 my-8 text-left align-middle transition-all transform bg-slate-800 border border-white/10 shadow-2xl rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
                    <h3 class="text-lg font-black text-white uppercase tracking-wider mb-6 pb-4 border-b border-white/10">Edit Data Pengadaan</h3>
                    <form :action="`/admin/bag-ada-inputs/${selectedData.id}`" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if(!Auth::user()->isAdminSatker())
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-xs font-bold text-slate-400 mb-2">Pilih Satker</label>
                                <select name="satker_id" x-model="selectedData.satker_id" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                                    <option value="">-- Pilih Satker --</option>
                                    @foreach($satkers as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif

                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Pelaku Pengadaan</label>
                                <select name="pelaku_pengadaan_id" x-model="selectedData.pelaku_pengadaan_id" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                                    <option value="">-- Pilih Peran --</option>
                                    @foreach($pelakus as $p)
                                        <option value="{{ $p->id }}">{{ $p->nama_peran }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" x-model="selectedData.nama" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Pangkat</label>
                                <input type="text" name="pangkat" x-model="selectedData.pangkat" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">NRP / NIP</label>
                                <input type="text" name="nrp_nip" x-model="selectedData.nrp_nip" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary">
                            </div>

                            <div class="col-span-1 md:col-span-2 bg-slate-900/50 p-4 rounded-xl border border-white/5 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <h4 class="col-span-1 md:col-span-2 text-xs font-black text-amber-500 uppercase tracking-widest">KEP / SPRIN</h4>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Nomor KEP/SPRIN</label>
                                    <input type="text" name="kep_nomor" x-model="selectedData.kep_nomor" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Tanggal KEP/SPRIN</label>
                                    <input type="date" name="kep_tanggal" x-model="selectedData.kep_tanggal ? selectedData.kep_tanggal.split('T')[0] : ''" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-xs font-bold text-slate-400 mb-2">Menangani Paket</label>
                                <input type="text" name="menangani_paket" x-model="selectedData.menangani_paket" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white">
                            </div>

                            <div class="col-span-1 md:col-span-2 bg-slate-900/50 p-4 rounded-xl border border-white/5 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <h4 class="col-span-1 md:col-span-2 text-xs font-black text-emerald-500 uppercase tracking-widest">Nilai</h4>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Nilai Pagu (Rp)</label>
                                    <input type="number" name="nilai_pagu" x-model="selectedData.nilai_pagu" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Nilai Kontrak (Rp)</label>
                                    <input type="number" name="nilai_kontrak" x-model="selectedData.nilai_kontrak" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Metode Pengadaan</label>
                                <select name="metode_pengadaan_id" x-model="selectedData.metode_pengadaan_id" required class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary">
                                    <option value="">-- Pilih Metode --</option>
                                    @foreach($metodes as $m)
                                        <option value="{{ $m->id }}">{{ $m->nama_metode }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-400 mb-2">Nama Penyedia</label>
                                <input type="text" name="nama_penyedia" x-model="selectedData.nama_penyedia" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white">
                            </div>

                            <div class="col-span-1 md:col-span-2 bg-slate-900/50 p-4 rounded-xl border border-white/5 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <h4 class="col-span-1 md:col-span-3 text-xs font-black text-blue-500 uppercase tracking-widest">Kontrak</h4>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Nomor Kontrak</label>
                                    <input type="text" name="kontrak_nomor" x-model="selectedData.kontrak_nomor" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Tanggal Mulai</label>
                                    <input type="date" name="kontrak_tanggal_mulai" x-model="selectedData.kontrak_tanggal_mulai ? selectedData.kontrak_tanggal_mulai.split('T')[0] : ''" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 mb-2">Tanggal Selesai</label>
                                    <input type="date" name="kontrak_tanggal_selesai" x-model="selectedData.kontrak_tanggal_selesai ? selectedData.kontrak_tanggal_selesai.split('T')[0] : ''" class="w-full bg-slate-800 border border-white/10 rounded-lg px-3 py-2 text-white text-sm">
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-xs font-bold text-slate-400 mb-2">Keterangan</label>
                                <textarea name="keterangan" x-model="selectedData.keterangan" rows="2" class="w-full bg-slate-900 border border-white/10 rounded-xl px-4 py-3 text-white focus:border-brand-primary focus:ring-brand-primary"></textarea>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-white/10">
                            <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:bg-white/5 transition-colors">Batal</button>
                            <button type="submit" class="px-8 py-2.5 rounded-xl text-xs font-bold bg-brand-primary text-white hover:bg-blue-600 transition-colors shadow-lg shadow-brand-primary/30">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>

    @if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm font-bold flex items-center gap-3">
        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
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

    <!-- Table Wrapper with overflow -->
    <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden relative">
        <div class="overflow-x-auto no-scrollbar" style="max-height: 70vh;">
            <table class="w-full text-left text-xs text-slate-300 min-w-max">
                <thead class="bg-slate-900 text-[10px] uppercase tracking-widest font-black text-slate-400 border-b border-white/10 sticky top-0 z-10 shadow-md">
                    <tr>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 text-center bg-slate-900 w-10">
                            <input type="checkbox" x-model="selectAll" @change="selectedIds = selectAll ? {{ json_encode($allInputs->pluck('id')) }} : []" class="w-4 h-4 rounded bg-slate-800 border-white/20 text-brand-primary focus:ring-brand-primary">
                        </th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 text-center bg-slate-900">NO</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 bg-slate-900">SATKER</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 bg-slate-900">PELAKU PENGADAAN</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 bg-slate-900">NAMA</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 bg-slate-900">PANGKAT</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 bg-slate-900">NRP/NIP</th>
                        <th scope="col" colspan="2" class="px-4 py-2 border-b border-r border-white/5 text-center text-amber-500 bg-slate-900">KEP/SPRIN</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 bg-slate-900">MENANGANI PAKET</th>
                        <th scope="col" colspan="2" class="px-4 py-2 border-b border-r border-white/5 text-center text-emerald-500 bg-slate-900">NILAI</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 bg-slate-900">METODE PENGADAAN</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 bg-slate-900">NAMA PENYEDIA</th>
                        <th scope="col" colspan="3" class="px-4 py-2 border-b border-r border-white/5 text-center text-blue-500 bg-slate-900">KONTRAK</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 border-r border-white/5 bg-slate-900">KETERANGAN</th>
                        <th scope="col" rowspan="2" class="px-4 py-3 bg-slate-900 text-center sticky right-0 shadow-[-10px_0_15px_-5px_rgba(0,0,0,0.5)]">AKSI</th>
                    </tr>
                    <tr>
                        <!-- KEP/SPRIN Sub -->
                        <th scope="col" class="px-4 py-2 border-r border-white/5 bg-slate-900">NOMOR</th>
                        <th scope="col" class="px-4 py-2 border-r border-white/5 bg-slate-900">TANGGAL</th>
                        <!-- NILAI Sub -->
                        <th scope="col" class="px-4 py-2 border-r border-white/5 bg-slate-900">PAGU (Rp)</th>
                        <th scope="col" class="px-4 py-2 border-r border-white/5 bg-slate-900">KONTRAK (Rp)</th>
                        <!-- KONTRAK Sub -->
                        <th scope="col" class="px-4 py-2 border-r border-white/5 bg-slate-900">NOMOR</th>
                        <th scope="col" class="px-4 py-2 border-r border-white/5 bg-slate-900">TGL MULAI</th>
                        <th scope="col" class="px-4 py-2 border-r border-white/5 bg-slate-900">TGL SELESAI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    @php $no = 1; @endphp
                    @forelse ($groupedInputs as $satkerId => $inputs)
                        @php $satker = $satkers->firstWhere('id', $satkerId); @endphp
                        @foreach($inputs as $index => $item)
                        <tr class="hover:bg-white/[0.03] transition-colors group">
                            <td class="px-4 py-3 text-center border-r border-white/5">
                                <input type="checkbox" x-model="selectedIds" value="{{ $item->id }}" class="w-4 h-4 rounded bg-slate-800 border-white/20 text-brand-primary focus:ring-brand-primary">
                            </td>
                            @if($index === 0)
                                <td class="px-4 py-3 text-center border-r border-white/5 align-top" rowspan="{{ count($inputs) }}">{{ $no++ }}</td>
                                <td class="px-4 py-3 font-bold text-white border-r border-white/5 whitespace-nowrap align-top" rowspan="{{ count($inputs) }}">{{ $satker->name ?? '-' }}</td>
                            @endif
                            @php
                                $peran = strtoupper($item->pelakuPengadaan->nama_peran ?? '');
                                $peranColor = 'text-brand-primary';
                                if ($peran === 'KPA') $peranColor = 'text-yellow-400';
                                elseif ($peran === 'PPK') $peranColor = 'text-red-400';
                                elseif ($peran === 'PP' || str_contains($peran, 'PEJABAT PENGADAAN')) $peranColor = 'text-emerald-400';
                                elseif (str_contains($peran, 'POKJA')) $peranColor = 'text-purple-400';
                                elseif (str_contains($peran, 'PPASM')) $peranColor = 'text-pink-400';
                            @endphp
                            <td class="px-4 py-3 font-black {{ $peranColor }} border-r border-white/5">{{ $item->pelakuPengadaan->nama_peran ?? '-' }}</td>
                            <td class="px-4 py-3 text-white border-r border-white/5 whitespace-nowrap">{{ $item->nama }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap">{{ $item->pangkat ?? '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap">{{ $item->nrp_nip ?? '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap">{{ $item->kep_nomor ?? '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap">{{ $item->kep_tanggal ? $item->kep_tanggal->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap" title="{{ $item->menangani_paket }}">{{ $item->menangani_paket ?? '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 text-right tabular-nums">{{ $item->nilai_pagu ? number_format($item->nilai_pagu, 0, ',', '.') : '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 text-right tabular-nums">{{ $item->nilai_kontrak ? number_format($item->nilai_kontrak, 0, ',', '.') : '-' }}</td>
                            <td class="px-4 py-3 font-bold border-r border-white/5">{{ $item->metodePengadaan->nama_metode ?? '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap">{{ $item->nama_penyedia ?? '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap">{{ $item->kontrak_nomor ?? '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap">{{ $item->kontrak_tanggal_mulai ? $item->kontrak_tanggal_mulai->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap">{{ $item->kontrak_tanggal_selesai ? $item->kontrak_tanggal_selesai->format('d/m/Y') : '-' }}</td>
                            <td class="px-4 py-3 border-r border-white/5 whitespace-nowrap" title="{{ $item->keterangan }}">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-4 py-3 text-center sticky right-0 bg-slate-900 group-hover:bg-slate-800 transition-colors shadow-[-5px_0_15px_-5px_rgba(0,0,0,0.3)]">
                                <div class="flex items-center gap-1 justify-center">
                                    <button type="button" @click="$dispatch('open-edit', {{ json_encode($item) }})" class="p-1.5 bg-blue-500/10 text-blue-400 hover:bg-blue-500 hover:text-white rounded transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                    </button>
                                    <form action="{{ route('admin.bag-ada-inputs.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirmDelete(this, 'Hapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-500/10 text-red-500 hover:bg-red-500 hover:text-white rounded transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @empty
                    <tr>
                        <td colspan="19" class="px-6 py-12 text-center text-slate-400 font-bold">
                            Belum ada data pengadaan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <!-- Import Modal -->
    <template x-teleport="body">
        <div x-show="importModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="importModalOpen" @click="importModalOpen = false" class="fixed inset-0 transition-opacity bg-slate-900/80 backdrop-blur-sm" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="importModalOpen" class="inline-block relative w-full max-w-md p-0 my-8 text-left align-middle transition-all transform" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <div class="relative bg-slate-900 rounded-3xl shadow-2xl border border-white/10 overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500/10 to-purple-500/10 pointer-events-none"></div>
                        
                        <div class="flex items-center justify-between p-6 border-b border-white/10 relative z-10">
                        <h3 class="text-xl font-black text-white uppercase tracking-wider">Import Data Excel</h3>
                        <button @click="importModalOpen = false" type="button" class="text-slate-400 bg-transparent hover:bg-white/5 hover:text-white rounded-xl text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                            </svg>
                        </button>
                    </div>

                    <div class="p-6 relative z-10">
                        <div class="mb-6">
                            <p class="text-sm text-slate-400 mb-4">Pastikan data yang Anda upload sesuai dengan format yang telah disediakan. Format kolom tidak boleh diubah.</p>
                            <a href="{{ route('admin.bag-ada-inputs.template') }}" class="inline-flex items-center gap-2 bg-emerald-500/10 text-emerald-400 px-4 py-3 rounded-xl text-xs font-bold hover:bg-emerald-500 hover:text-white transition-colors w-full justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                                Download Format Excel
                            </a>
                        </div>

                        <form action="{{ route('admin.bag-ada-inputs.import-process', [], false) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="path" x-model="tempPath">
                            
                            <div class="mb-6">
                                <label class="block mb-2 text-xs font-bold text-slate-300 uppercase tracking-widest">Upload File Excel</label>
                                <input type="file" @change="validateExcel" name="file_excel" accept=".xlsx, .xls" required class="block w-full text-sm text-slate-400 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-500/20 file:text-blue-400 hover:file:bg-blue-500 hover:file:text-white cursor-pointer bg-slate-800/50 rounded-xl border border-white/5 transition-all">
                                @error('file_excel')
                                    <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Area Status Validasi -->
                            <div x-show="validationResult === 'ok'" class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold flex items-center gap-3" style="display: none;">
                                <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                File valid dan siap di-import!
                            </div>

                            <!-- Area Mapping -->
                            <div x-show="validationResult === 'mapping_required'" style="display: none;" class="mb-6 border-t border-white/10 pt-4">
                                <div class="p-4 rounded-xl bg-amber-500/10 border border-amber-500/20 mb-4">
                                    <div class="flex items-center gap-2 text-amber-400 mb-2">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                        <h4 class="text-xs font-bold">Ditemukan Kesalahan Data</h4>
                                    </div>
                                    <p class="text-[10px] text-slate-300">Ada nama yang tidak cocok dengan database. Silakan pilih perbaikannya di bawah ini, atau pilih "Abaikan".</p>
                                </div>

                                <div class="space-y-4 max-h-[40vh] overflow-y-auto no-scrollbar pr-2">
                                    <!-- Satker Mapping -->
                                    <template x-if="unmatched && unmatched.satker && unmatched.satker.length > 0">
                                        <div class="bg-slate-800/50 p-3 rounded-xl border border-white/5">
                                            <h5 class="text-[10px] font-black text-white uppercase tracking-widest mb-3 border-b border-white/5 pb-2">Satker Salah</h5>
                                            <template x-for="name in unmatched.satker" :key="name">
                                                <div class="mb-3 last:mb-0">
                                                    <label class="block text-[10px] font-bold text-red-400 mb-1" x-text="'&quot;' + name + '&quot;'"></label>
                                                    <select :name="'map_satker[' + name + ']'" class="w-full bg-slate-900 border border-white/10 rounded-lg px-3 py-2 text-white text-[10px] focus:border-brand-primary">
                                                        <option value="">-- Abaikan (Baris Dilewati) --</option>
                                                        <template x-for="opt in options.satker" :key="opt.id">
                                                            <option :value="opt.id" x-text="opt.name"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Pelaku Mapping -->
                                    <template x-if="unmatched && unmatched.pelaku && unmatched.pelaku.length > 0">
                                        <div class="bg-slate-800/50 p-3 rounded-xl border border-white/5">
                                            <h5 class="text-[10px] font-black text-white uppercase tracking-widest mb-3 border-b border-white/5 pb-2">Pelaku Salah</h5>
                                            <template x-for="name in unmatched.pelaku" :key="name">
                                                <div class="mb-3 last:mb-0">
                                                    <label class="block text-[10px] font-bold text-red-400 mb-1" x-text="'&quot;' + name + '&quot;'"></label>
                                                    <select :name="'map_pelaku[' + name + ']'" class="w-full bg-slate-900 border border-white/10 rounded-lg px-3 py-2 text-white text-[10px] focus:border-brand-primary">
                                                        <option value="">-- Abaikan (Dikosongkan) --</option>
                                                        <template x-for="opt in options.pelaku" :key="opt.id">
                                                            <option :value="opt.id" x-text="opt.nama_peran"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Metode Mapping -->
                                    <template x-if="unmatched && unmatched.metode && unmatched.metode.length > 0">
                                        <div class="bg-slate-800/50 p-3 rounded-xl border border-white/5">
                                            <h5 class="text-[10px] font-black text-white uppercase tracking-widest mb-3 border-b border-white/5 pb-2">Metode Salah</h5>
                                            <template x-for="name in unmatched.metode" :key="name">
                                                <div class="mb-3 last:mb-0">
                                                    <label class="block text-[10px] font-bold text-red-400 mb-1" x-text="'&quot;' + name + '&quot;'"></label>
                                                    <select :name="'map_metode[' + name + ']'" class="w-full bg-slate-900 border border-white/10 rounded-lg px-3 py-2 text-white text-[10px] focus:border-brand-primary">
                                                        <option value="">-- Abaikan (Dikosongkan) --</option>
                                                        <template x-for="opt in options.metode" :key="opt.id">
                                                            <option :value="opt.id" x-text="opt.nama_metode"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                                <button @click="importModalOpen = false" type="button" class="w-full text-white bg-slate-800 hover:bg-slate-700 font-bold rounded-xl text-xs px-5 py-3 text-center uppercase tracking-wider transition-colors">Batal</button>
                                <button type="submit" :disabled="isValidating || !validationResult" class="w-full text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed focus:ring-4 focus:outline-none focus:ring-blue-500/50 font-bold rounded-xl text-xs px-5 py-3 text-center uppercase tracking-wider transition-all shadow-[0_0_20px_rgba(0,98,255,0.3)]">
                                    <span x-show="!isValidating">Import</span>
                                    <span x-show="isValidating">Memvalidasi...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </template>
</div>

@endsection
