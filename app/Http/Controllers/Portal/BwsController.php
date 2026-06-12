<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\BwsReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BwsController extends Controller
{
    public function index()
    {
        return view('portal.bws.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bagian' => 'required|string',
            'nama' => 'required|string|max:255',
            'nomor_hp' => 'required|string|max:20',
            'jenis_laporan' => 'required|string|in:KORUPSI,PUNGLI,KESEWENANG',
            'aduan' => 'required|string',
            'bukti_dukung' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('bukti_dukung')) {
            $file = $request->file('bukti_dukung');
            $fileHash = md5_file($file->getRealPath());

            // Check if exact same file was already uploaded
            $existingReports = BwsReport::all();
            $duplicateReport = null;
            foreach ($existingReports as $report) {
                if ($report->bukti_dukung && Storage::disk('public')->exists($report->bukti_dukung)) {
                    $existingHash = md5_file(Storage::disk('public')->path($report->bukti_dukung));
                    if ($existingHash === $fileHash) {
                        $duplicateReport = $report;
                        break;
                    }
                }
            }

            if ($duplicateReport) {
                // Same file found — update existing report, reuse the file
                $duplicateReport->update([
                    'bagian' => $request->bagian,
                    'nama' => $request->nama,
                    'nomor_hp' => $request->nomor_hp,
                    'jenis_laporan' => $request->jenis_laporan,
                    'aduan' => $request->aduan,
                ]);

                return redirect()->route('portal.bws.index')->with('success', 'Pengaduan Anda telah berhasil diperbarui (dokumen pendukung sama).');
            }

            // Different file — store with unique name so nothing gets overwritten
            $uniqueName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bws_reports', $uniqueName, 'public');
        }

        // Always create new report when document is different
        BwsReport::create([
            'bagian' => $request->bagian,
            'nama' => $request->nama,
            'nomor_hp' => $request->nomor_hp,
            'jenis_laporan' => $request->jenis_laporan,
            'aduan' => $request->aduan,
            'bukti_dukung' => $filePath,
        ]);

        return redirect()->route('portal.bws.index')->with('success', 'Pengaduan Anda telah berhasil dikirim.');
    }
}
