@extends('admin.layout')

@section('title', 'Dashboard Ringkasan')

@section('content')
<div class="space-y-8">
    <!-- Welcome Header -->
    <!-- Welcome Header -->
    <div class="bg-brand-primary rounded-[2.5rem] p-12 lg:p-16 text-white shadow-2xl shadow-brand-primary/20 relative overflow-hidden group">
        <div class="absolute inset-0 z-0 opacity-10 bg-[radial-gradient(circle_at_2px_2px,rgba(255,255,255,0.4)_1px,transparent_0)] [background-size:32px_32px]"></div>
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-white/10 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-10">
            <div class="max-w-2xl text-center md:text-left">
                <h2 class="text-4xl lg:text-5xl font-black tracking-tight mb-6 font-outfit uppercase italic">Commander, {{ Auth::user()->name }}</h2>
                <p class="text-blue-50 text-xl font-bold font-outfit leading-relaxed italic opacity-80">
                    Sistem operasional "SILOGIS" berada dalam kendali penuh Anda. Persiapkan publikasi strategis dan monitoring ekosistem hari ini.
                </p>
                <div class="mt-10 flex flex-wrap justify-center md:justify-start gap-4">
                    <a href="{{ route('admin.news.create') }}" class="bg-white text-brand-primary px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] shadow-2xl hover:scale-105 transition-all italic">Launch Publication</a>
                    <a href="{{ route('admin.apps.create') }}" class="bg-slate-900/40 backdrop-blur-md text-white px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] border border-white/20 hover:bg-slate-900 transition-all italic">Register Asset</a>
                </div>
            </div>
            <div class="hidden lg:block relative">
                 <div class="h-44 w-44 bg-white/10 rounded-[3rem] rotate-12 flex items-center justify-center backdrop-blur-2xl border border-white/20 shadow-2xl group-hover:rotate-0 transition-all duration-700">
                      <svg class="h-24 w-24 text-white -rotate-12 group-hover:rotate-0 transition-all duration-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                 </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-slate-900/50 backdrop-blur-2xl p-10 rounded-[2.5rem] shadow-2xl border border-white/5 flex items-center justify-between group hover:border-brand-primary/30 transition-all">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-600 mb-4">Total Application Assets</p>
                <h3 class="text-6xl font-black text-white font-outfit italic tracking-tighter">{{ $appsCount }}</h3>
                <a href="{{ route('admin.apps.index') }}" class="mt-6 inline-block text-[10px] font-black uppercase tracking-widest text-brand-primary hover:text-white transition-all italic">Manage Ecosystem &rarr;</a>
            </div>
            <div class="h-20 w-20 bg-slate-800 rounded-3xl flex items-center justify-center text-brand-primary group-hover:bg-brand-primary group-hover:text-white transition-all duration-500 shadow-2xl">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
            </div>
        </div>
        
        <div class="bg-slate-900/50 backdrop-blur-2xl p-10 rounded-[2.5rem] shadow-2xl border border-white/5 flex items-center justify-between group hover:border-brand-primary/30 transition-all">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-600 mb-4">Narrative Publications</p>
                <h3 class="text-6xl font-black text-white font-outfit italic tracking-tighter">{{ $newsCount }}</h3>
                <a href="{{ route('admin.news.index') }}" class="mt-6 inline-block text-[10px] font-black uppercase tracking-widest text-brand-primary hover:text-white transition-all italic">Review Archives &rarr;</a>
            </div>
            <div class="h-20 w-20 bg-slate-800 rounded-3xl flex items-center justify-center text-brand-primary group-hover:bg-brand-primary group-hover:text-white transition-all duration-500 shadow-2xl">
                <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20" /></svg>
            </div>
        </div>
    </div>

    <!-- Quick Info Section -->
    <div class="bg-slate-900/50 backdrop-blur-2xl rounded-[2.5rem] p-10 text-white relative overflow-hidden border border-white/5 shadow-22xl italic">
        <div class="relative z-10">
            <h4 class="text-[10px] font-black uppercase tracking-[0.4em] mb-8 text-slate-500">Security & Operational Guidelines</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="group">
                    <p class="text-[10px] font-black uppercase tracking-widest text-brand-primary mb-3">Asset Visualization</p>
                    <p class="text-[11px] text-slate-400 font-bold leading-relaxed opacity-80 group-hover:opacity-100 transition-opacity">Gunakan format ikon PNG transparan tingkat tinggi untuk menjaga estetika katalog ekosistem tetap premium.</p>
                </div>
                <div class="group border-l border-white/5 pl-10">
                    <p class="text-[10px] font-black uppercase tracking-widest text-brand-primary mb-3">Narrative Engine</p>
                    <p class="text-[11px] text-slate-400 font-bold leading-relaxed opacity-80 group-hover:opacity-100 transition-opacity">Sistem kecerdasan narasi kami secara otomatis mengoptimalkan SLUG untuk visibilitas mesin pencari global.</p>
                </div>
                <div class="group border-l border-white/5 pl-10">
                    <p class="text-[10px] font-black uppercase tracking-widest text-brand-primary mb-3">Data Integrity</p>
                    <p class="text-[11px] text-slate-400 font-bold leading-relaxed opacity-80 group-hover:opacity-100 transition-opacity">Selalu lakukan audit data secara berkala. Hapus entitas yang sudah tidak memenuhi standar protokol pimpinan.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
