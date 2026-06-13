<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use Illuminate\Http\Request;

class BagianController extends Controller
{
    public function index()
    {
        $bagians = Bagian::latest()->get();
        return view('admin.bagians.index', compact('bagians'));
    }

    public function create()
    {
        return view('admin.bagians.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:bagians,name',
            'description' => 'nullable|string',
        ]);

        Bagian::create($request->all());

        return redirect()->route('admin.bagians.index')->with('success', 'Bagian berhasil ditambahkan.');
    }

    public function edit(Bagian $bagian)
    {
        return view('admin.bagians.edit', compact('bagian'));
    }

    public function update(Request $request, Bagian $bagian)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:bagians,name,' . $bagian->id,
            'description' => 'nullable|string',
        ]);

        $bagian->update($request->all());

        return redirect()->route('admin.bagians.index')->with('success', 'Bagian berhasil diperbarui.');
    }

    public function destroy(Bagian $bagian)
    {
        $bagian->delete();

        return redirect()->route('admin.bagians.index')->with('success', 'Bagian berhasil dihapus.');
    }
}
