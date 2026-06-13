@extends('admin.layout')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="mb-8">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-white transition-colors mb-4">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Kembali ke Katalog Pengguna
    </a>
    <h2 class="text-2xl font-black text-white font-outfit uppercase tracking-tight">Tambah Pengguna</h2>
</div>

<div class="max-w-2xl bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl p-8">
    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                    class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all">
                @error('name')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required
                    class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all">
                @error('email')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Password</label>
                <input type="password" id="password" name="password" required
                    class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all">
                @error('password')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all">
            </div>

            <div>
                <label for="role" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Role Akses</label>
                <select id="role" name="role" required onchange="toggleBagian()"
                    class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all appearance-none">
                    <option value="admin_satker" {{ old('role') == 'admin_satker' ? 'selected' : '' }}>Admin Satker</option>
                    <option value="admin_bag" {{ old('role') == 'admin_bag' ? 'selected' : '' }}>Admin Bagian</option>
                    <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('role')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div id="bagian-container" class="{{ old('role') == 'admin_bag' ? 'block' : 'hidden' }}">
                <label for="bagian_id" class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">Pilih Bagian</label>
                <select id="bagian_id" name="bagian_id" 
                    class="w-full bg-slate-950/50 border border-white/10 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-all appearance-none">
                    <option value="">-- Pilih Bagian --</option>
                    @foreach($bagians as $bagian)
                        <option value="{{ $bagian->id }}" {{ old('bagian_id') == $bagian->id ? 'selected' : '' }}>{{ $bagian->name }}</option>
                    @endforeach
                </select>
                @error('bagian_id')
                    <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="pt-4 border-t border-white/5 flex justify-end">
            <button type="submit" class="bg-gradient-to-r from-brand-primary to-indigo-600 px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest text-white hover:shadow-[0_0_20px_rgba(0,98,255,0.4)] transition-all hover:scale-105 active:scale-95">
                Simpan Pengguna
            </button>
        </div>
    </form>
</div>

<script>
    function toggleBagian() {
        const role = document.getElementById('role').value;
        const container = document.getElementById('bagian-container');
        if (role === 'admin_bag') {
            container.classList.remove('hidden');
            container.classList.add('block');
        } else {
            container.classList.remove('block');
            container.classList.add('hidden');
        }
    }
    // Initialize on load
    document.addEventListener('DOMContentLoaded', toggleBagian);
</script>
@endsection
