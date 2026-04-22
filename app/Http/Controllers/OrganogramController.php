<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Organogram;
use Illuminate\Support\Facades\Storage;

class OrganogramController extends Controller
{
    public function index()
    {
        $organograms = Organogram::with('parent')->orderBy('parent_id')->orderBy('order')->get();
        return view('admin.organograms.index', compact('organograms'));
    }

    public function create()
    {
        $parents = Organogram::orderBy('parent_id')->get();
        return view('admin.organograms.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'rank' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:organograms,id',
            'photo' => 'nullable|image|max:2048',
            'order' => 'required|integer'
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('organograms', 'public');
        }

        Organogram::create($validated);
        return redirect()->route('admin.organograms.index')->with('success', 'Struktur berhasil ditambahkan.');
    }

    public function edit(Organogram $organogram)
    {
        $parents = Organogram::where('id', '!=', $organogram->id)->get();
        return view('admin.organograms.edit', compact('organogram', 'parents'));
    }

    public function update(Request $request, Organogram $organogram)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'rank' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:organograms,id',
            'photo' => 'nullable|image|max:2048',
            'order' => 'required|integer'
        ]);

        if ($request->hasFile('photo')) {
            if ($organogram->photo) Storage::disk('public')->delete($organogram->photo);
            $validated['photo'] = $request->file('photo')->store('organograms', 'public');
        }

        $organogram->update($validated);
        return redirect()->route('admin.organograms.index')->with('success', 'Struktur berhasil diupdate.');
    }

    public function destroy(Organogram $organogram)
    {
        if ($organogram->photo) Storage::disk('public')->delete($organogram->photo);
        $organogram->delete();
        return redirect()->route('admin.organograms.index')->with('success', 'Struktur berhasil dihapus.');
    }
}
