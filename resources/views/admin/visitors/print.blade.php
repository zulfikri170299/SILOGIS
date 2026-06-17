<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pengunjung - SILOGIS</title>
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
            text-align: center; border-bottom: none; margin-bottom: 24px;
        }
        .report-header h1 { font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 3px; text-decoration: underline; }

        /* Summary Cards */
        .summary-row {
            display: flex; gap: 12px; margin-bottom: 24px; justify-content: center;
        }
        .summary-card {
            background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px;
            padding: 14px 24px; text-align: center; min-width: 150px;
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

        .footer-note {
            text-align: center; font-size: 9px; color: #94a3b8; margin-top: 30px; 
            border-top: 1px solid #e2e8f0; padding-top: 12px;
        }

        /* Mobile Responsiveness for Preview */
        @media screen and (max-width: 640px) {
            body { padding-top: 130px; }
            .print-bar { flex-direction: column; padding: 12px; gap: 10px; }
            .print-bar > span { font-size: 11px; }
            .print-bar > div { width: 100%; justify-content: center; }
            .print-bar button { padding: 10px; font-size: 10px; flex: 1; letter-spacing: 0.5px; }
            
            .page { padding: 15px !important; }
            .page:first-of-type { margin-top: 0 !important; }
            
            .summary-row { flex-wrap: wrap; gap: 8px; }
            .summary-card { flex: 1 1 100%; padding: 10px; }
            .summary-card .value { font-size: 18px; }
            
            .report-header h1 { font-size: 14px; letter-spacing: 1px; }
            
            .data-table { display: block; overflow-x: auto; white-space: nowrap; }
        }
    </style>
</head>
<body>

<!-- Print Button Bar -->
<div class="print-bar no-print">
    <span>Preview Laporan Pengunjung</span>
    <div style="display:flex; gap:10px;">
        <button onclick="window.print()">🖨️ Cetak / Simpan PDF</button>
        <button onclick="window.close()" style="background:#475569;">✕ Tutup</button>
    </div>
</div>

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

    <div class="report-header">
        <h1>LAPORAN DATA PENGUNJUNG</h1>
        @if(request('search'))
        <div style="font-size: 10px; color: #64748b; margin-top: 5px; font-weight: bold;">
            Filter Pencarian: "{{ request('search') }}"
        </div>
        @endif
    </div>

    <!-- Summary Cards -->
    <div class="summary-row">
        <div class="summary-card">
            <div class="label">Total Pengunjung Unik</div>
            <div class="value">{{ $visitors->count() }}</div>
        </div>
        <div class="summary-card">
            <div class="label">Total Kunjungan</div>
            <div class="value">{{ $visitors->sum('logs_count') }}</div>
        </div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:30px">No</th>
                <th>Nama</th>
                <th>Satuan Kerja</th>
                <th style="text-align: center;">Total Kunjungan</th>
                <th>Terakhir Kunjung</th>
            </tr>
        </thead>
        <tbody>
            @forelse($visitors as $visitor)
            @php
                $terakhirKunjung = $visitor->logs->isNotEmpty() 
                    ? \Carbon\Carbon::parse($visitor->logs->first()->visited_at)->translatedFormat('d M Y, H:i') 
                    : \Carbon\Carbon::parse($visitor->created_at)->translatedFormat('d M Y, H:i');
            @endphp
            <tr>
                <td style="font-weight:700;">{{ $loop->iteration }}</td>
                <td style="font-weight:700;">{{ $visitor->nama }}</td>
                <td>{{ $visitor->satuan_kerja ?? '-' }}</td>
                <td style="text-align: center; font-weight: 700;">{{ $visitor->logs_count }} kali</td>
                <td style="white-space:nowrap;">{{ $terakhirKunjung }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center; padding:30px; color:#94a3b8;">Tidak ada data pengunjung.</td></tr>
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
        setTimeout(function() { 
            // Optional: you can auto-print here
        }, 500);
    });
</script>
</body>
</html>
