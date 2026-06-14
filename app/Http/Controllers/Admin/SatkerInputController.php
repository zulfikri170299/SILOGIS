<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SatkerInputController extends Controller
{
    public function index(Request $request, $bagianId)
    {
        $bagian = \App\Models\Bagian::findOrFail($bagianId);
        
        $query = \App\Models\SatkerInput::with(['satker', 'bagian'])->where('bagian_id', $bagianId)->latest();

        if (auth()->user()->role === 'admin_satker') {
            $query->where('satker_id', auth()->user()->satker_id);
        }

        $inputs = $query->get();

        return view('admin.satker_inputs.index', compact('inputs', 'bagian'));
    }

    public function create($bagianId)
    {
        if (auth()->user()->role !== 'admin_satker') {
            abort(403, 'Hanya Admin Satker yang dapat menambah inputan.');
        }

        $bagian = \App\Models\Bagian::findOrFail($bagianId);
        return view('admin.satker_inputs.create', compact('bagian'));
    }

    public function store(Request $request, $bagianId)
    {
        if (auth()->user()->role !== 'admin_satker') {
            abort(403);
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_lampiran' => 'nullable|file|max:10240',
        ]);

        $input = new \App\Models\SatkerInput();
        $input->satker_id = auth()->user()->satker_id;
        $input->bagian_id = $bagianId;
        $input->judul = $request->judul;
        $input->deskripsi = $request->deskripsi;

        if ($request->hasFile('file_lampiran')) {
            $input->file_lampiran = $request->file('file_lampiran')->store('satker_inputs', 'public');
        }

        $input->save();

        return redirect()->route('admin.satker_inputs.index', $bagianId)->with('success', 'Inputan berhasil dikirim ke Bagian.');
    }

    public function destroy($id)
    {
        $input = \App\Models\SatkerInput::findOrFail($id);
        
        // Superadmin or the satker that created it can delete
        if (auth()->user()->role !== 'superadmin' && (auth()->user()->role !== 'admin_satker' || auth()->user()->satker_id !== $input->satker_id)) {
            abort(403);
        }

        if ($input->file_lampiran) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($input->file_lampiran);
        }
        $bagianId = $input->bagian_id;
        $input->delete();

        return redirect()->route('admin.satker_inputs.index', $bagianId)->with('success', 'Inputan berhasil dihapus.');
    }
}
