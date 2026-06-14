<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pengaduan WBS - SILOGIS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            color: #1e293b; 
            font-size: 11px;
            background: #fff;
        }

        @page {
            size: A4 portrait;
            margin: 0; /* Removes default browser header/footer */
        }

        @media print {
            body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
            .page { padding: 0mm 15mm 15mm 15mm; max-width: none; margin: 0; box-sizing: border-box; }
            .page:first-of-type { margin-top: 0; padding-top: 0; }
        }

        /* Print Button Bar */
        .print-bar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 999;
            background: #0f172a; color: #fff; padding: 12px 24px;
            display: flex; align-items: center; justify-content: space-between;
        }
        .print-bar button {
            background: #16a34a; color: #fff; border: none; padding: 10px 28px;
            border-radius: 8px; font-weight: 800; font-size: 12px; cursor: pointer;
            text-transform: uppercase; letter-spacing: 2px;
        }
        .print-bar button:hover { background: #15803d; }
        .print-bar span { font-weight: 800; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; }

        /* Page Container */
        .page {
            max-width: 210mm; margin: 0 auto; padding: 20mm 15mm;
        }
        .page:first-of-type { margin-top: 60px; }

        /* Header */
        .report-header {
            text-align: center; border-bottom: 3px solid #0f172a; padding-bottom: 16px; margin-bottom: 24px;
        }
        .report-header h1 { font-size: 20px; font-weight: 900; text-transform: uppercase; letter-spacing: 3px; }
        .report-header h2 { font-size: 14px; font-weight: 700; color: #64748b; margin-top: 4px; }
        .report-header .meta { font-size: 10px; color: #94a3b8; margin-top: 8px; }

        /* Chart Section */
        .chart-section {
            display: flex; gap: 30px; margin-top: 20px; align-items: flex-start;
        }
        .chart-donut { flex-shrink: 0; width: 200px; height: 200px; position: relative; }
        .chart-donut .center-label {
            position: absolute; inset: 0; display: flex; flex-direction: column;
            align-items: center; justify-content: center;
        }
        .chart-donut .center-label .num { font-size: 28px; font-weight: 900; }
        .chart-donut .center-label .lbl { font-size: 9px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; }

        .chart-legend { flex: 1; }
        .chart-legend table { width: 100%; border-collapse: collapse; }
        .chart-legend th { 
            text-align: left; font-size: 9px; font-weight: 800; text-transform: uppercase; 
            letter-spacing: 1px; color: #64748b; padding: 8px 10px; border-bottom: 2px solid #e2e8f0; 
        }
        .chart-legend td { padding: 10px; border-bottom: 1px solid #f1f5f9; font-weight: 600; }
        .chart-legend .color-dot { 
            display: inline-block; width: 10px; height: 10px; border-radius: 50%; margin-right: 8px; vertical-align: middle; 
        }
        .chart-legend .bar-bg { background: #f1f5f9; height: 6px; border-radius: 3px; overflow: hidden; margin-top: 4px; }
        .chart-legend .bar-fill { height: 100%; border-radius: 3px; }

        /* Summary Cards */
        .summary-row {
            display: flex; gap: 12px; margin-bottom: 24px;
        }
        .summary-card {
            flex: 1; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;
            padding: 14px 16px; text-align: center;
        }
        .summary-card .label { font-size: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 1.5px; color: #94a3b8; }
        .summary-card .value { font-size: 22px; font-weight: 900; color: #0f172a; margin-top: 4px; }

        /* Data Table */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        .data-table th {
            background: #0f172a; color: #fff; font-size: 9px; font-weight: 800; 
            text-transform: uppercase; letter-spacing: 1px; padding: 10px 8px; text-align: left;
        }
        .data-table td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; vertical-align: top; }
        .data-table tr:nth-child(even) { background: #f8fafc; }
        .data-table .bagian-badge {
            display: inline-block; padding: 2px 8px; border-radius: 4px;
            font-size: 8px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;
        }

        .footer-note {
            text-align: center; font-size: 9px; color: #94a3b8; margin-top: 30px; 
            border-top: 1px solid #e2e8f0; padding-top: 12px;
        }
    </style>
</head>
<body>

<!-- Print Button Bar -->
<div class="print-bar no-print">
    <span>Preview Laporan WBS</span>
    <div style="display:flex; gap:10px;">
        <button onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
        <button onclick="window.close()" style="background:#475569;">✕ Tutup</button>
    </div>
</div>

@php
    $colors = ['#f59e0b','#3b82f6','#10b981','#8b5cf6','#ec4899','#ef4444','#06b6d4'];
    $bagianColors = [];
    $i = 0;
    foreach ($bwsStats as $bag => $count) {
        $bagianColors[$bag] = $colors[$i % count($colors)];
        $i++;
    }
@endphp

<!-- PAGE 1: Summary & Chart -->
<div class="page">
    <!-- KOP SURAT -->
    <div style="display: inline-block; text-align: center; margin-bottom: 30px; margin-top: -20px;">
        <img src="{{ asset('OIP (3).jpg') }}" alt="Logo Logistik Polri" style="width: 60px; height: auto; margin-bottom: 8px;">
        <div style="font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; line-height: 1.3;">
            KEPOLISIAN NEGARA REPUBLIK INDONESIA<br>
            DAERAH NUSA TENGGARA BARAT<br>
            BIRO LOGISTIK
        </div>
        <div style="border-bottom: 2px solid #000; margin-top: 5px;"></div>
    </div>

    <div class="report-header" style="border-bottom: none;">
        <h1 style="font-size:16px; text-decoration: underline;">WHISTLEBLOWING SYSTEM</h1>
    </div>

    <!-- Summary Cards -->
    <div class="summary-row">
        <div class="summary-card">
            <div class="label">Total Laporan</div>
            <div class="value">{{ $totalReports }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Bagian Aktif</div>
            <div class="value">{{ collect($bwsStats)->filter(fn($v) => $v > 0)->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Terbanyak</div>
            <div class="value" style="font-size:13px;">{{ $totalReports > 0 ? array_keys($bwsStats, max($bwsStats))[0] : '-' }}</div>
        </div>
    </div>

    <!-- Chart + Legend -->
    <h3 style="font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:2px; color:#64748b; margin-bottom:16px;">Distribusi Per Bagian</h3>
    <div class="chart-section">
        <div class="chart-donut">
            @if($totalReports > 0)
                @php $cumPercent = 0; @endphp
                <svg viewBox="0 0 42 42" width="200" height="200" style="transform:rotate(-90deg)">
                    @foreach($bwsStats as $bag => $count)
                        @php
                            $pct = ($count / $totalReports) * 100;
                            $clr = $bagianColors[$bag];
                            $da = $pct . ' ' . (100 - $pct);
                            $doff = 100 - $cumPercent;
                            $cumPercent += $pct;
                        @endphp
                        @if($pct > 0)
                        <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="{{ $clr }}" stroke-width="5"
                            stroke-dasharray="{{ $da }}" stroke-dashoffset="{{ $doff }}"></circle>
                        @endif
                    @endforeach
                    <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#e2e8f0" stroke-width="5" style="z-index:-1"></circle>
                </svg>
            @else
                <svg viewBox="0 0 42 42" width="200" height="200">
                    <circle cx="21" cy="21" r="15.9155" fill="transparent" stroke="#e2e8f0" stroke-width="5"></circle>
                </svg>
            @endif
            <div class="center-label">
                <span class="num">{{ $totalReports }}</span>
                <span class="lbl">Total</span>
            </div>
        </div>

        <div class="chart-legend">
            <table>
                <thead>
                    <tr><th>Bagian</th><th style="text-align:center">Jumlah</th><th style="text-align:right">Persen</th></tr>
                </thead>
                <tbody>
                @foreach($bwsStats as $bag => $count)
                    @php $pct = $totalReports > 0 ? round(($count / $totalReports) * 100) : 0; @endphp
                    <tr>
                        <td>
                            <span class="color-dot" style="background:{{ $bagianColors[$bag] }}"></span>{{ $bag }}
                            <div class="bar-bg"><div class="bar-fill" style="width:{{ $pct }}%; background:{{ $bagianColors[$bag] }}"></div></div>
                        </td>
                        <td style="text-align:center; font-weight:800;">{{ $count }}</td>
                        <td style="text-align:right; font-weight:700; color:#64748b;">{{ $pct }}%</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- PAGE 2+: Data Table -->
<div class="page page-break">
    <!-- KOP SURAT -->
    <div style="display: inline-block; text-align: center; margin-bottom: 30px; margin-top: -20px;">
        <img src="{{ asset('OIP (3).jpg') }}" alt="Logo Logistik Polri" style="width: 60px; height: auto; margin-bottom: 8px;">
        <div style="font-family: Arial, sans-serif; font-size: 13px; font-weight: bold; line-height: 1.3;">
            KEPOLISIAN NEGARA REPUBLIK INDONESIA<br>
            DAERAH NUSA TENGGARA BARAT<br>
            BIRO LOGISTIK
        </div>
        <div style="border-bottom: 2px solid #000; margin-top: 5px;"></div>
    </div>

    <div class="report-header" style="border-bottom: none;">
        <h1 style="font-size:16px; text-decoration: underline;">WHISTLEBLOWING SYSTEM</h1>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:30px">No</th>
                <th>Tanggal</th>
                <th>Bagian</th>
                <th>Jenis</th>
                <th style="width:45%">Isi Aduan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $item)
            <tr>
                <td style="font-weight:700;">{{ $loop->iteration }}</td>
                <td style="white-space:nowrap;">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <span class="bagian-badge" style="background:{{ $bagianColors[$item->bagian] ?? '#64748b' }}20; color:{{ $bagianColors[$item->bagian] ?? '#64748b' }}; border:1px solid {{ $bagianColors[$item->bagian] ?? '#64748b' }}40;">
                        {{ $item->bagian }}
                    </span>
                </td>
                <td style="font-weight:700; font-size:9px;">{{ $item->jenis_laporan ?? '-' }}</td>
                <td>{{ $item->aduan }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; padding:30px; color:#94a3b8;">Tidak ada data.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer-note">
        Dokumen ini dicetak secara otomatis oleh Sistem Informasi Logistik (SILOGIS) — {{ now()->translatedFormat('d F Y, H:i') }} WIB
    </div>
</div>

<script>
    // Auto-trigger print dialog after page loads
    window.addEventListener('load', function() {
        // Small delay to ensure everything is rendered
        setTimeout(function() { /* ready */ }, 500);
    });
</script>
</body>
</html>
