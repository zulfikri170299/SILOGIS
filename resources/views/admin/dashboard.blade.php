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
    @php
        $totalReports = array_sum($bwsStats);
    @endphp
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach ($bwsStats as $bag => $count)
        @php
            $percentage = $totalReports > 0 ? round(($count / $totalReports) * 100) : 0;
            $dashArray = $percentage . ', 100';
        @endphp
        <div class="bg-slate-900/50 backdrop-blur-2xl p-6 md:p-8 rounded-[2rem] shadow-2xl border border-white/5 flex flex-col justify-between group hover:border-amber-500/30 transition-all">
            <div class="flex items-center justify-between mb-6">
                <!-- Radial Progress Diagram -->
                <div class="relative w-16 h-16">
                    <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                        <!-- Background Circle -->
                        <path class="text-slate-800" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                        <!-- Progress Circle -->
                        <path class="text-amber-500 group-hover:text-brand-primary transition-colors duration-500" stroke-dasharray="{{ $dashArray }}" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-xs font-black text-white italic">{{ $percentage }}%</span>
                    </div>
                </div>
            </div>
            <div>
                <h3 class="text-5xl font-black text-white font-outfit italic tracking-tighter mb-2">{{ $count }}</h3>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">{{ $bag }}</p>
                <a href="{{ route('admin.bws.index') }}?bagian={{ urlencode($bag) }}" class="mt-4 inline-block text-[9px] font-black uppercase tracking-widest text-brand-primary hover:text-white transition-all italic">Lihat Pengaduan &rarr;</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
