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
            'aduan' => 'required|string',
            'bukti_dukung' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = null;
        if ($request->hasFile('bukti_dukung')) {
            $filePath = $request->file('bukti_dukung')->store('bws_reports', 'public');
        }

        BwsReport::create([
            'bagian' => $request->bagian,
            'nama' => $request->nama,
            'nomor_hp' => $request->nomor_hp,
            'aduan' => $request->aduan,
            'bukti_dukung' => $filePath,
        ]);

        return redirect()->route('portal.bws.index')->with('success', 'Pengaduan Anda telah berhasil dikirim.');
    }
}
