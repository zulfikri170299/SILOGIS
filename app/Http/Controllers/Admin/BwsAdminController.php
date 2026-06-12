<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BwsReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BwsAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = BwsReport::latest();
        if ($request->filled('bagian')) {
            $query->where('bagian', $request->bagian);
        }
        $reports = $query->get();
        return view('admin.bws.index', compact('reports'));
    }

    public function destroy(BwsReport $bws)
    {
        if ($bws->bukti_dukung) {
            Storage::disk('public')->delete($bws->bukti_dukung);
        }
        $bws->delete();

        return redirect()->route('admin.bws.index')->with('success', 'Laporan berhasil dihapus');
    }

    public function updateLogo(Request $request)
    {
        $profile = \App\Models\Profile::firstOrCreate([]);
        $request->validate(['bws_logo' => 'required|image|max:2048']);

        if ($request->hasFile('bws_logo')) {
            if ($profile->bws_logo) {
                Storage::disk('public')->delete($profile->bws_logo);
            }
            $profile->bws_logo = $request->file('bws_logo')->store('profile', 'public');
            $profile->save();
        }

        return redirect()->route('admin.bws.index')->with('success', 'Logo BWS berhasil diperbarui.');
    }
}
