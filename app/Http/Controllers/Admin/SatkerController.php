<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satker;
use Illuminate\Http\Request;

class SatkerController extends Controller
{
    public function index()
    {
        $satkers = Satker::orderBy('urutan')->orderBy('name')->get();
        return view('admin.satkers.index', compact('satkers'));
    }

    public function create()
    {
        return view('admin.satkers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:satkers,name',
            'urutan' => 'nullable|integer',
        ]);

        Satker::create($request->all());

        return redirect()->route('admin.satkers.index')->with('success', 'Satker berhasil ditambahkan.');
    }

    public function edit(Satker $satker)
    {
        return view('admin.satkers.edit', compact('satker'));
    }

    public function update(Request $request, Satker $satker)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:satkers,name,' . $satker->id,
            'urutan' => 'nullable|integer',
        ]);

        $satker->update($request->all());

        return redirect()->route('admin.satkers.index')->with('success', 'Satker berhasil diperbarui.');
    }

    public function destroy(Satker $satker)
    {
        $satker->delete();

        return redirect()->route('admin.satkers.index')->with('success', 'Satker berhasil dihapus.');
    }
}
