<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterMetodePengadaan;
use Illuminate\Http\Request;

class MasterMetodePengadaanController extends Controller
{
    public function index()
    {
        $metodes = MasterMetodePengadaan::orderBy('nama_metode')->get();
        return view('admin.master_metode.index', compact('metodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_metode' => 'required|string|max:255|unique:master_metode_pengadaans'
        ]);

        MasterMetodePengadaan::create($request->all());
        return redirect()->route('admin.master-metode.index')->with('success', 'Metode Pengadaan berhasil ditambahkan.');
    }

    public function update(Request $request, MasterMetodePengadaan $master_metode)
    {
        $request->validate([
            'nama_metode' => 'required|string|max:255|unique:master_metode_pengadaans,nama_metode,' . $master_metode->id
        ]);

        $master_metode->update($request->all());
        return redirect()->route('admin.master-metode.index')->with('success', 'Metode Pengadaan berhasil diubah.');
    }

    public function destroy(MasterMetodePengadaan $master_metode)
    {
        $master_metode->delete();
        return redirect()->route('admin.master-metode.index')->with('success', 'Metode Pengadaan berhasil dihapus.');
    }
}
