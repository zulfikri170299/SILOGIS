<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BagAdaInput;
use App\Models\MasterMetodePengadaan;
use App\Models\MasterPelakuPengadaan;
use App\Models\Satker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BagAdaInputImport;

class BagAdaInputController extends Controller
{
    public function index(Request $request)
    {
        $query = BagAdaInput::with(['satker', 'pelakuPengadaan', 'metodePengadaan', 'user'])->latest();

        $user = Auth::user();

        // Admin Satker hanya bisa melihat data miliknya sendiri
        if ($user->isAdminSatker()) {
            $query->where('satker_id', $user->satker_id);
        } else if ($request->filled('satker_id')) {
            $query->where('satker_id', $request->satker_id);
        }

        if ($request->filled('pelaku_pengadaan_id')) {
            $query->where('pelaku_pengadaan_id', $request->pelaku_pengadaan_id);
        }

        $tahun = $request->input('tahun', date('Y'));
        $query->whereYear('created_at', $tahun);

        $allInputs = $query->get()->sortBy(function($input) {
            return $input->satker->urutan ?? 999;
        });

        $groupedInputs = $allInputs->groupBy('satker_id');

        $rekapanPelaku = $allInputs->groupBy(function ($item) {
            return $item->pelakuPengadaan->nama_peran ?? 'Tanpa Peran';
        })->map->count();

        // Ambil daftar tahun unik dari database untuk dropdown filter
        $yearsFromDb = BagAdaInput::select('created_at')->get()
            ->map(function($item) { return $item->created_at->format('Y'); })
            ->toArray();
        
        $yearsFromDb[] = date('Y'); // Pastikan tahun berjalan selalu ada di pilihan
        $availableYears = collect($yearsFromDb)->unique()->sortDesc();

        $satkers = Satker::orderBy('urutan')->orderBy('name')->get();
        $pelakus = MasterPelakuPengadaan::orderBy('nama_peran')->get();
        $metodes = MasterMetodePengadaan::orderBy('nama_metode')->get();

        return view('admin.bag_ada_inputs.index', compact('groupedInputs', 'allInputs', 'rekapanPelaku', 'satkers', 'pelakus', 'metodes', 'availableYears'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelaku_pengadaan_id' => 'required|exists:master_pelaku_pengadaans,id',
            'nama' => 'required|string|max:255',
            'metode_pengadaan_id' => 'required|exists:master_metode_pengadaans,id',
            'satker_id' => Auth::user()->isAdminSatker() ? 'nullable' : 'required|exists:satkers,id',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if (Auth::user()->isAdminSatker()) {
            $data['satker_id'] = Auth::user()->satker_id;
        }

        BagAdaInput::create($data);

        return redirect()->route('admin.bag-ada-inputs.index')->with('success', 'Data Pengadaan berhasil ditambahkan.');
    }

    public function update(Request $request, BagAdaInput $bag_ada_input)
    {
        $request->validate([
            'pelaku_pengadaan_id' => 'required|exists:master_pelaku_pengadaans,id',
            'nama' => 'required|string|max:255',
            'metode_pengadaan_id' => 'required|exists:master_metode_pengadaans,id',
            'satker_id' => Auth::user()->isAdminSatker() ? 'nullable' : 'required|exists:satkers,id',
        ]);

        $data = $request->all();
        if (Auth::user()->isAdminSatker()) {
            $data['satker_id'] = Auth::user()->satker_id;
        }

        $bag_ada_input->update($data);

        return redirect()->route('admin.bag-ada-inputs.index')->with('success', 'Data Pengadaan berhasil diubah.');
    }

    public function destroy(BagAdaInput $bag_ada_input)
    {
        $bag_ada_input->delete();
        return redirect()->route('admin.bag-ada-inputs.index')->with('success', 'Data Pengadaan berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:bag_ada_inputs,id'
        ]);

        BagAdaInput::whereIn('id', $request->ids)->delete();
        return redirect()->route('admin.bag-ada-inputs.index')->with('success', 'Data yang dipilih berhasil dihapus.');
    }

    public function export(Request $request)
    {
        return Excel::download(new \App\Exports\BagAdaInputExport($request), 'data_pengadaan_bag_ada.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new BagAdaInputImport, $request->file('file_excel'));
            return redirect()->route('admin.bag-ada-inputs.index')->with('success', 'Data berhasil diimport dari Excel.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bag-ada-inputs.index')->with('error', 'Gagal mengimport data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filepath = public_path('laporan/TEMPLATE_IMPORT_PENGADAAN.xlsx');
        if (file_exists($filepath)) {
            return response()->download($filepath, 'Template_Import_Pengadaan.xlsx');
        }
        
        return redirect()->route('admin.bag-ada-inputs.index')->with('error', 'File template belum tersedia. Silakan hubungi developer.');
    }
}
