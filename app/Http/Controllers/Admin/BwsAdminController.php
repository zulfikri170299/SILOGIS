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

        if (auth()->user()->isAdminBag() && auth()->user()->bagian) {
            $query->where('bagian', auth()->user()->bagian->name);
        } else if ($request->filled('bagian')) {
            $query->where('bagian', $request->bagian);
        }

        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        $perPage = $request->input('per_page', 10);
        $reports = $query->paginate($perPage)->appends($request->query());
        $bagians = \App\Models\Bagian::orderBy('name')->pluck('name')->toArray();

        return view('admin.bws.index', compact('reports', 'bagians'));
    }

    public function printReport(Request $request)
    {
        $query = BwsReport::latest();

        if (auth()->user()->isAdminBag() && auth()->user()->bagian) {
            $query->where('bagian', auth()->user()->bagian->name);
        } else if ($request->filled('bagian')) {
            $query->where('bagian', $request->bagian);
        }

        if ($request->filled('jenis_laporan')) {
            $query->where('jenis_laporan', $request->jenis_laporan);
        }
        if ($request->filled('dari')) {
            $query->whereDate('created_at', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('created_at', '<=', $request->sampai);
        }

        $reports = $query->get();

        // Stats for chart
        $bagianList = auth()->user()->isAdminBag() && auth()->user()->bagian 
            ? [auth()->user()->bagian->name] 
            : \App\Models\Bagian::orderBy('name')->pluck('name')->toArray();
        
        $bwsStats = [];
        foreach ($bagianList as $bag) {
            $bwsStats[$bag] = $reports->where('bagian', $bag)->count();
        }
        $totalReports = $reports->count();

        return view('admin.bws.print', compact('reports', 'bwsStats', 'totalReports', 'request'));
    }

    public function destroy(BwsReport $bws)
    {
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        if ($bws->bukti_dukung) {
            Storage::disk('public')->delete($bws->bukti_dukung);
        }
        if ($bws->bukti_dukung_tambahan) {
            Storage::disk('public')->delete($bws->bukti_dukung_tambahan);
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

        return redirect()->route('logo.edit')->with('success', 'Logo WBS berhasil diperbarui.');
    }
}
