@extends('admin.layout')

@section('title', 'Dashboard Ringkasan')

@section('content')
@php
    $totalReports = array_sum($bwsStats);
    $palette = [
        ['bg' => '#f59e0b', 'text' => 'text-amber-500',   'ring' => 'ring-amber-500/30'],
        ['bg' => '#3b82f6', 'text' => 'text-blue-500',    'ring' => 'ring-blue-500/30'],
        ['bg' => '#10b981', 'text' => 'text-emerald-500', 'ring' => 'ring-emerald-500/30'],
        ['bg' => '#8b5cf6', 'text' => 'text-violet-500',  'ring' => 'ring-violet-500/30'],
        ['bg' => '#ec4899', 'text' => 'text-pink-500',    'ring' => 'ring-pink-500/30'],
        ['bg' => '#ef4444', 'text' => 'text-red-500',     'ring' => 'ring-red-500/30'],
        ['bg' => '#06b6d4', 'text' => 'text-cyan-500',    'ring' => 'ring-cyan-500/30'],
        ['bg' => '#f97316', 'text' => 'text-orange-500',  'ring' => 'ring-orange-500/30'],
        ['bg' => '#14b8a6', 'text' => 'text-teal-500',    'ring' => 'ring-teal-500/30'],
        ['bg' => '#a855f7', 'text' => 'text-purple-500',  'ring' => 'ring-purple-500/30'],
    ];
    $colors = [];
    $i = 0;
    foreach(array_keys($bwsStats) as $bag) {
        $colors[$bag] = $palette[$i % count($palette)];
        $i++;
    }
@endphp

<div class="space-y-8">

    <!-- Year Filter Bar -->
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-black text-white uppercase tracking-widest font-outfit">Statistik WBS</h2>
        <form method="GET" action="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <label class="text-[9px] font-black uppercase tracking-widest text-slate-500">Tahun</label>
            <select name="tahun" onchange="this.form.submit()"
                class="bg-slate-800 border border-white/10 rounded-xl text-white text-xs font-bold py-2.5 px-4 focus:border-brand-primary focus:ring-brand-primary pr-8 appearance-none"
                style="background-image: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 20 20%22><path stroke=%22%2394a3b8%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M6 8l4 4 4-4%22/></svg>'); background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1.2em;">
                @foreach($availableYears as $year)
                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Summary Cards Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-2xl border border-white/5 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Total Laporan</p>
                <h3 class="text-2xl font-black text-white font-outfit">{{ $totalReports }}</h3>
            </div>
        </div>
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-2xl border border-white/5 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Total Bagian</p>
                <h3 class="text-2xl font-black text-white font-outfit">{{ count($bwsStats) }}</h3>
            </div>
        </div>
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-2xl border border-white/5 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
            <div>
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Terbanyak</p>
                @php $topBag = $totalReports > 0 ? array_keys($bwsStats, max($bwsStats))[0] : '-'; @endphp
                <h3 class="text-sm font-black text-white font-outfit uppercase truncate">{{ $topBag }}</h3>
            </div>
        </div>
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-2xl border border-white/5 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-violet-500/10 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[9px] font-black uppercase tracking-widest text-slate-500">Laporan Hari Ini</p>
                @php $today = \App\Models\BwsReport::whereDate('created_at', today())->count(); @endphp
                <h3 class="text-2xl font-black text-white font-outfit">{{ $today }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Content: Donut Chart + Legend Table -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Donut Chart Card -->
        <div class="lg:col-span-5 bg-slate-900/80 backdrop-blur-2xl rounded-2xl border border-white/5 p-6 md:p-8">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-6">Distribusi Pengaduan WBS</h3>
            
            <div class="flex items-center justify-center">
                <div class="relative w-56 h-56 md:w-64 md:h-64">
                    @if($totalReports > 0)
                        @php
                            $cumulativePercent = 0;
                        @endphp
                        <svg viewBox="0 0 42 42" class="w-full h-full" style="transform: rotate(-90deg);">
                            <!-- Background ring -->
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#1e293b" stroke-width="5"></circle>
                            <!-- Colored segments -->
                            @foreach($bwsStats as $bag => $count)
                                @php
                                    $percent = ($count / $totalReports) * 100;
                                    $color = $colors[$bag]['bg'] ?? '#64748b';
                                    $circumference = 100;
                                    $dashArray = $percent . ' ' . ($circumference - $percent);
                                    $dashOffset = 25 - $cumulativePercent;
                                    $cumulativePercent += $percent;
                                @endphp
                                @if($percent > 0)
                                <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="{{ $color }}" stroke-width="5"
                                    stroke-dasharray="{{ $dashArray }}" stroke-dashoffset="{{ $dashOffset }}"
                                    class="transition-all duration-700"></circle>
                                @endif
                            @endforeach
                        </svg>
                    @else
                        <svg viewBox="0 0 42 42" class="w-full h-full">
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#1e293b" stroke-width="5"></circle>
                        </svg>
                    @endif
                    <!-- Center Text -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-4xl font-black text-white font-outfit">{{ $totalReports }}</span>
                        <span class="text-[9px] font-black uppercase tracking-widest text-slate-500 mt-1">Total</span>
                    </div>
                </div>
            </div>

            <!-- Color Legend -->
            <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-2">
                @foreach($bwsStats as $bag => $count)
                    @php $color = $colors[$bag]['bg'] ?? '#64748b'; @endphp
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full shrink-0" style="background: {{ $color }};"></span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider truncate">{{ $bag }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Detail Table Card -->
        <div class="lg:col-span-7 bg-slate-900/80 backdrop-blur-2xl rounded-2xl border border-white/5 p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Rincian Per Bagian</h3>
                <a href="{{ route('admin.bws.index') }}" class="text-[9px] font-black uppercase tracking-widest text-brand-primary hover:text-white transition-colors">Lihat Semua &rarr;</a>
            </div>
            
            <div class="space-y-3">
                @foreach($bwsStats as $bag => $count)
                @php
                    $percent = $totalReports > 0 ? round(($count / $totalReports) * 100) : 0;
                    $color = $colors[$bag]['bg'] ?? '#64748b';
                    $textColor = $colors[$bag]['text'] ?? 'text-slate-500';
                @endphp
                <a href="{{ route('admin.bws.index') }}?bagian={{ urlencode($bag) }}" class="flex items-center gap-4 p-4 rounded-xl bg-slate-800/40 border border-white/5 hover:border-white/10 hover:bg-slate-800/80 transition-all group">
                    <!-- Color indicator -->
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background: {{ $color }}15; border: 1px solid {{ $color }}30;">
                        <span class="text-xs font-black {{ $textColor }}">{{ $percent }}%</span>
                    </div>
                    
                    <!-- Name & Progress bar -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-black text-white uppercase tracking-wider truncate">{{ $bag }}</span>
                            <span class="text-xs font-black text-slate-400 shrink-0 ml-2">{{ $count }} <span class="text-slate-600 text-[9px]">laporan</span></span>
                        </div>
                        <div class="w-full h-1.5 bg-slate-800 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-700" style="width: {{ $percent }}%; background: {{ $color }};"></div>
                        </div>
                    </div>

                    <!-- Arrow -->
                    <svg class="w-4 h-4 text-slate-600 group-hover:text-white shrink-0 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Jenis Laporan per Bagian -->
    @php
        $jenisColors = [
            'KORUPSI KOLUSI DAN NEPOTISME' => ['bg' => '#ef4444', 'text' => 'text-red-400'],
            'PUNGUTAN LIAR' => ['bg' => '#8b5cf6', 'text' => 'text-violet-400'],
            'PENYALAHGUNAAN WEWENANG' => ['bg' => '#ec4899', 'text' => 'text-pink-400'],
            'PENYALAHGUNAAN NARKOBA' => ['bg' => '#3b82f6', 'text' => 'text-blue-400'],
            'LAINNYA' => ['bg' => '#10b981', 'text' => 'text-emerald-400'],
        ];
    @endphp
    <div class="bg-slate-900/80 backdrop-blur-2xl rounded-2xl border border-white/5 p-6 md:p-8">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Jenis Laporan Per Bagian</h3>
            <div class="flex items-center gap-4">
                @foreach($jenisColors as $jenis => $jc)
                    <div class="flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background: {{ $jc['bg'] }};"></span>
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">{{ $jenis }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-white/10">
                        <th class="text-[9px] font-black uppercase tracking-widest text-slate-500 py-3 px-3">Bagian</th>
                        @foreach(['KORUPSI KOLUSI DAN NEPOTISME','PUNGUTAN LIAR','PENYALAHGUNAAN WEWENANG','PENYALAHGUNAAN NARKOBA','LAINNYA'] as $jenis)
                            <th class="text-[9px] font-black uppercase tracking-widest py-3 px-3 text-center {{ $jenisColors[$jenis]['text'] }}">{{ $jenis }}</th>
                        @endforeach
                        <th class="text-[9px] font-black uppercase tracking-widest text-slate-500 py-3 px-3 text-center">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jenisPerBagian as $bag => $jenisData)
                    @php $bagTotal = array_sum($jenisData); @endphp
                    <tr class="border-b border-white/5 hover:bg-slate-800/30 transition-colors">
                        <td class="py-3 px-3">
                            <span class="text-xs font-black text-white uppercase tracking-wider">{{ $bag }}</span>
                        </td>
                        @foreach(['KORUPSI KOLUSI DAN NEPOTISME','PUNGUTAN LIAR','PENYALAHGUNAAN WEWENANG','PENYALAHGUNAAN NARKOBA','LAINNYA'] as $jenis)
                            <td class="py-3 px-3 text-center">
                                @if($jenisData[$jenis] > 0)
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-xs font-black text-white" style="background: {{ $jenisColors[$jenis]['bg'] }};">
                                        {{ $jenisData[$jenis] }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-600 font-bold">0</span>
                                @endif
                            </td>
                        @endforeach
                        <td class="py-3 px-3 text-center">
                            <span class="text-sm font-black text-white">{{ $bagTotal }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- News & Documents Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- News Bar Chart Card -->
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-2xl border border-white/5 p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Publikasi Berita</h3>
                    <p class="text-2xl font-black text-white font-outfit mt-1">{{ $totalNews }} <span class="text-sm text-slate-500">total</span></p>
                </div>
                <a href="{{ route('admin.news.index') }}" class="text-[9px] font-black uppercase tracking-widest text-brand-primary hover:text-white transition-colors">Kelola &rarr;</a>
            </div>

            <!-- Bar Chart (6 bulan terakhir) -->
            @php $maxNews = max(1, max(array_values($newsMonthly))); @endphp
            <div class="flex items-end justify-between gap-2 h-40 mt-4">
                @foreach($newsMonthly as $month => $count)
                @php
                    $barHeight = ($count / $maxNews) * 100;
                    $barColors = ['#f59e0b', '#3b82f6', '#10b981', '#8b5cf6', '#ec4899', '#06b6d4'];
                    $barColor = $barColors[$loop->index % count($barColors)];
                @endphp
                <div class="flex-1 flex flex-col items-center gap-2 h-full justify-end">
                    <span class="text-[10px] font-black text-white">{{ $count }}</span>
                    <div class="w-full rounded-t-lg transition-all duration-700 min-h-[4px]" style="height: {{ max(4, $barHeight) }}%; background: {{ $barColor }};"></div>
                    <span class="text-[8px] font-bold text-slate-500 uppercase tracking-wider whitespace-nowrap">{{ explode(' ', $month)[0] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Documents Donut Chart Card -->
        <div class="bg-slate-900/80 backdrop-blur-2xl rounded-2xl border border-white/5 p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Arsip Dokumen</h3>
                    <p class="text-2xl font-black text-white font-outfit mt-1">{{ $totalDocs }} <span class="text-sm text-slate-500">total</span></p>
                </div>
                <a href="{{ route('admin.documents.index') }}" class="text-[9px] font-black uppercase tracking-widest text-brand-primary hover:text-white transition-colors">Kelola &rarr;</a>
            </div>

            @php
                $docColors = ['#f59e0b', '#3b82f6', '#10b981', '#8b5cf6', '#ec4899', '#ef4444', '#06b6d4', '#f97316', '#14b8a6', '#a855f7'];
            @endphp

            <div class="flex flex-col md:flex-row items-center gap-6">
                <!-- Donut -->
                <div class="relative w-40 h-40 shrink-0">
                    @if($totalDocs > 0)
                        @php $cumDoc = 0; @endphp
                        <svg viewBox="0 0 42 42" class="w-full h-full" style="transform: rotate(-90deg);">
                            @foreach($docStats as $folderName => $docCount)
                                @php
                                    $pct = ($docCount / $totalDocs) * 100;
                                    $clr = $docColors[$loop->index % count($docColors)];
                                    $da = $pct . ' ' . (100 - $pct);
                                    $doff = 100 - $cumDoc;
                                    $cumDoc += $pct;
                                @endphp
                                @if($pct > 0)
                                <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="{{ $clr }}" stroke-width="4.5"
                                    stroke-dasharray="{{ $da }}" stroke-dashoffset="{{ $doff }}" class="transition-all duration-700"></circle>
                                @endif
                            @endforeach
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#1e293b" stroke-width="4.5" style="z-index:-1"></circle>
                        </svg>
                    @else
                        <svg viewBox="0 0 42 42" class="w-full h-full">
                            <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#1e293b" stroke-width="4.5"></circle>
                        </svg>
                    @endif
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-2xl font-black text-white font-outfit">{{ $totalDocs }}</span>
                        <span class="text-[8px] font-black uppercase tracking-widest text-slate-500">File</span>
                    </div>
                </div>

                <!-- Folder Legend List -->
                <div class="flex-1 space-y-2 w-full">
                    @forelse($docStats as $folderName => $docCount)
                        @php
                            $clr = $docColors[$loop->index % count($docColors)];
                            $pct = $totalDocs > 0 ? round(($docCount / $totalDocs) * 100) : 0;
                        @endphp
                        <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-800/50 transition-colors">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background: {{ $clr }};"></span>
                            <span class="text-[10px] font-bold text-slate-300 uppercase tracking-wider truncate flex-1">{{ $folderName }}</span>
                            <span class="text-[10px] font-black text-white shrink-0">{{ $docCount }}</span>
                            <span class="text-[9px] font-bold text-slate-500 shrink-0 w-8 text-right">{{ $pct }}%</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 italic text-center py-4">Belum ada folder dokumen.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
