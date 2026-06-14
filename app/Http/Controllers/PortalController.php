<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\News;
use App\Models\Document;
use App\Models\DocumentFolder;
use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class PortalController extends Controller
{
    public function index()
    {
        $visitorEmail = \Illuminate\Support\Facades\Cookie::get('visitor_email');
        if ($visitorEmail) {
            $visitor = \App\Models\Visitor::where('email', $visitorEmail)->first();
            if ($visitor) {
                // Cari log terakhir pengunjung ini
                $lastLog = \App\Models\VisitorLog::where('visitor_id', $visitor->id)->latest('visited_at')->first();
                
                // Rekam kunjungan baru jika belum ada log, atau jika log terakhir lebih dari 1 menit yang lalu
                // (Untuk menghindari spam ketika pengunjung melakukan refresh berulang kali)
                if (!$lastLog || $lastLog->visited_at->diffInMinutes(now()) >= 1) {
                    \App\Models\VisitorLog::create([
                        'visitor_id' => $visitor->id,
                        'visited_at' => now(),
                    ]);
                }
            }
        }

        $apps = App::orderByRaw('urutan IS NULL, urutan ASC')->get();
        $news = News::latest()->take(8)->get();
        // Ambil folder yang punya dokumen
        $folders = DocumentFolder::with(['documents' => function($q) {
            $q->latest();
        }])->latest()->get();

        // Dokumen yang tidak punya folder
        $standaloneDocuments = Document::whereNull('document_folder_id')->latest()->get();

        $profile = \App\Models\Profile::first(['*']);
        $organograms = \App\Models\Organogram::whereNull('parent_id')->with('children.children.children')->orderBy('order')->get();
        $bagians = \App\Models\Bagian::orderBy('name')->get();
        
        return view('index', compact('apps', 'news', 'folders', 'standaloneDocuments', 'profile', 'organograms', 'bagians'));
    }

    public function downloadFolder(DocumentFolder $documentFolder)
    {
        $zipName = str_replace(' ', '_', $documentFolder->name) . '.zip';
        $zipPath = storage_path('app/public/' . $zipName);
        
        $zip = new ZipArchive;
        
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $documents = $documentFolder->documents;
            
            foreach ($documents as $doc) {
                $filePath = storage_path('app/public/' . $doc->file_path);
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, $doc->original_filename);
                }
            }
            
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function show(News $news)
    {
        $profile = \App\Models\Profile::first();
        return view('news.show', compact('news', 'profile'));
    }

    public function newsIndex()
    {
        $news = News::latest()->paginate(12);
        $profile = \App\Models\Profile::first();
        return view('news.index', compact('news', 'profile'));
    }
}
