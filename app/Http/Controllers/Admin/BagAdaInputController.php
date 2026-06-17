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
use Illuminate\Support\Facades\Storage;

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
            'file_kontrak' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if (Auth::user()->isAdminSatker()) {
            $data['satker_id'] = Auth::user()->satker_id;
        }

        if ($request->hasFile('file_kontrak')) {
            $data['file_kontrak'] = $request->file('file_kontrak')->store('kontrak_pdfs', 'public');
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
            'file_kontrak' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = $request->all();
        if (Auth::user()->isAdminSatker()) {
            $data['satker_id'] = Auth::user()->satker_id;
        }

        if ($request->hasFile('file_kontrak')) {
            if ($bag_ada_input->file_kontrak) {
                Storage::disk('public')->delete($bag_ada_input->file_kontrak);
            }
            $data['file_kontrak'] = $request->file('file_kontrak')->store('kontrak_pdfs', 'public');
        }

        $bag_ada_input->update($data);

        return redirect()->route('admin.bag-ada-inputs.index')->with('success', 'Data Pengadaan berhasil diubah.');
    }

    public function destroy(BagAdaInput $bag_ada_input)
    {
        if ($bag_ada_input->file_kontrak) {
            Storage::disk('public')->delete($bag_ada_input->file_kontrak);
        }
        $bag_ada_input->delete();
        return redirect()->route('admin.bag-ada-inputs.index')->with('success', 'Data Pengadaan berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:bag_ada_inputs,id'
        ]);

        BagAdaInput::whereIn('id', $request->ids)->get()->each(function($input) {
            if ($input->file_kontrak) {
                Storage::disk('public')->delete($input->file_kontrak);
            }
            $input->delete();
        });
        return redirect()->route('admin.bag-ada-inputs.index')->with('success', 'Data yang dipilih berhasil dihapus.');
    }

    public function export(Request $request)
    {
        return Excel::download(new \App\Exports\BagAdaInputExport($request), 'data_pengadaan_bag_ada.xlsx');
    }

    public function importValidate(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls'
        ]);

        try {
            $file = $request->file('file_excel');
            
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('temp_imports', $filename);
            
            // Get full absolute path using Storage facade
            $fullPath = \Illuminate\Support\Facades\Storage::path($path);
            
            $data = Excel::toArray(new BagAdaInputImport, $fullPath);
            
            if (empty($data) || empty($data[0])) {
                return response()->json(['status' => 'error', 'message' => 'File Excel kosong atau format tidak sesuai.']);
            }
            
            $rows = $data[0];
            
            $satkersDb = Satker::pluck('name', 'id')->map(function($name) { return strtolower(trim($name)); })->toArray();
            $pelakusDb = MasterPelakuPengadaan::pluck('nama_peran', 'id')->map(function($name) { return strtolower(trim($name)); })->toArray();
            $metodesDb = MasterMetodePengadaan::pluck('nama_metode', 'id')->map(function($name) { return strtolower(trim($name)); })->toArray();
            
            $unmatchedSatker = [];
            $unmatchedPelaku = [];
            $unmatchedMetode = [];
            
            foreach ($rows as $row) {
                if (empty(array_filter($row))) continue;
                
                $sName = isset($row['satker']) ? strtolower(trim($row['satker'])) : '';
                if ($sName && !in_array($sName, $satkersDb) && !in_array($sName, $unmatchedSatker)) {
                    $unmatchedSatker[] = $row['satker'];
                }
                
                $pName = isset($row['pelaku_pengadaan']) ? strtolower(trim($row['pelaku_pengadaan'])) : '';
                if ($pName && !in_array($pName, $pelakusDb) && !in_array($pName, $unmatchedPelaku)) {
                    $unmatchedPelaku[] = $row['pelaku_pengadaan'];
                }
                
                $mName = isset($row['metode_pengadaan']) ? strtolower(trim($row['metode_pengadaan'])) : '';
                if ($mName && !in_array($mName, $metodesDb) && !in_array($mName, $unmatchedMetode)) {
                    $unmatchedMetode[] = $row['metode_pengadaan'];
                }
            }
            
            if (!empty($unmatchedSatker) || !empty($unmatchedPelaku) || !empty($unmatchedMetode)) {
                $satkers = Satker::orderBy('name')->get(['id', 'name']);
                $pelakus = MasterPelakuPengadaan::orderBy('nama_peran')->get(['id', 'nama_peran']);
                $metodes = MasterMetodePengadaan::orderBy('nama_metode')->get(['id', 'nama_metode']);
                
                return response()->json([
                    'status' => 'mapping_required',
                    'path' => $path,
                    'unmatched' => [
                        'satker' => $unmatchedSatker,
                        'pelaku' => $unmatchedPelaku,
                        'metode' => $unmatchedMetode,
                    ],
                    'options' => [
                        'satker' => $satkers,
                        'pelaku' => $pelakus,
                        'metode' => $metodes,
                    ]
                ]);
            }

            return response()->json([
                'status' => 'ok',
                'path' => $path
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Gagal memvalidasi data: ' . $e->getMessage()]);
        }
    }

    public function importProcess(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $mapping = [
            'satker' => $request->input('map_satker', []),
            'pelaku' => $request->input('map_pelaku', []),
            'metode' => $request->input('map_metode', []),
        ];

        try {
            $import = new BagAdaInputImport($mapping);
            $fullPath = \Illuminate\Support\Facades\Storage::path($request->path);
            Excel::import($import, $fullPath);
            
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }

            return redirect()->route('admin.bag-ada-inputs.index')->with('success', 'Data berhasil diimport.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bag-ada-inputs.index')->with('error', 'Gagal memproses import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\TemplateImportPengadaanExport, 'Template_Import_Pengadaan.xlsx');
    }
}
