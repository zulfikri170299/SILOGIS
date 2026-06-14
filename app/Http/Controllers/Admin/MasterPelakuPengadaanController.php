<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterPelakuPengadaan;
use Illuminate\Http\Request;

class MasterPelakuPengadaanController extends Controller
{
    public function index()
    {
        $pelakus = MasterPelakuPengadaan::orderBy('nama_peran')->get();
        return view('admin.master_pelaku.index', compact('pelakus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_peran' => 'required|string|max:255|unique:master_pelaku_pengadaans'
        ]);

        MasterPelakuPengadaan::create($request->all());
        return redirect()->route('admin.master-pelaku.index')->with('success', 'Pelaku Pengadaan berhasil ditambahkan.');
    }

    public function update(Request $request, MasterPelakuPengadaan $master_pelaku)
    {
        $request->validate([
            'nama_peran' => 'required|string|max:255|unique:master_pelaku_pengadaans,nama_peran,' . $master_pelaku->id
        ]);

        $master_pelaku->update($request->all());
        return redirect()->route('admin.master-pelaku.index')->with('success', 'Pelaku Pengadaan berhasil diubah.');
    }

    public function destroy(MasterPelakuPengadaan $master_pelaku)
    {
        $master_pelaku->delete();
        return redirect()->route('admin.master-pelaku.index')->with('success', 'Pelaku Pengadaan berhasil dihapus.');
    }
}
