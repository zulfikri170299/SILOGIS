<?php

namespace App\Http\Controllers;

use App\Models\DocumentFolder;
use Illuminate\Http\Request;

class DocumentFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folders = DocumentFolder::withCount('documents')->latest()->get();
        return view('admin.document-folders.index', compact('folders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.document-folders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        DocumentFolder::create($request->all());

        return redirect()->route('admin.document-folders.index')->with('success', 'Folder berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentFolder $documentFolder)
    {
        return view('admin.document-folders.edit', compact('documentFolder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentFolder $documentFolder)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $documentFolder->update($request->all());

        return redirect()->route('admin.document-folders.index')->with('success', 'Folder berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentFolder $documentFolder)
    {
        // Many files will have their document_folder_id set to null (cascade is set to null in migration)
        $documentFolder->delete();

        return redirect()->route('admin.document-folders.index')->with('success', 'Folder berhasil dihapus.');
    }
}
