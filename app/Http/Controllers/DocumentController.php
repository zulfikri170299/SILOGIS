<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::with('folder')->latest()->get();
        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $folders = DocumentFolder::orderBy('name')->get();
        return view('admin.documents.create', compact('folders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:20480', // Max 20MB
            'category' => 'nullable|string|max:255',
            'document_folder_id' => 'nullable|exists:document_folders,id',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileType = $file->getClientOriginalExtension();
            $fileSize = $this->formatBytes($file->getSize());
            
            $path = $file->store('documents', 'public');

            Document::create([
                'title' => $request->title,
                'original_filename' => $originalName,
                'file_path' => $path,
                'file_type' => $fileType,
                'file_size' => $fileSize,
                'category' => $request->category,
                'document_folder_id' => $request->document_folder_id,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diunggah.');
        }

        return back()->with('error', 'Gagal mengunggah file.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        $folders = DocumentFolder::orderBy('name')->get();
        return view('admin.documents.edit', compact('document', 'folders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:20480',
            'category' => 'nullable|string|max:255',
            'document_folder_id' => 'nullable|exists:document_folders,id',
            'description' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'document_folder_id' => $request->document_folder_id,
            'description' => $request->description,
        ];

        if ($request->hasFile('file')) {
            // Delete old file
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            $file = $request->file('file');
            $data['original_filename'] = $file->getClientOriginalName();
            $data['file_type'] = $file->getClientOriginalExtension();
            $data['file_size'] = $this->formatBytes($file->getSize());
            $data['file_path'] = $file->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
