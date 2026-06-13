<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Year filter (SQLite compatible)
        $availableYearsBws = \App\Models\BwsReport::selectRaw("strftime('%Y', created_at) as year")->distinct()->pluck('year')->toArray();
        $availableYearsNews = \App\Models\News::selectRaw("strftime('%Y', created_at) as year")->distinct()->pluck('year')->toArray();
        $availableYearsDocs = \App\Models\Document::selectRaw("strftime('%Y', created_at) as year")->distinct()->pluck('year')->toArray();
        
        $availableYears = array_unique(array_merge($availableYearsBws, $availableYearsNews, $availableYearsDocs));
        rsort($availableYears);

        if (empty($availableYears)) {
            $availableYears = [now()->year];
        }
        $selectedYear = (string) $request->input('tahun', now()->year);

        $bagianList = ['SUBBAGRENMIN', 'BAG FASKON', 'BAG PAL', 'BAG INFOLOG', 'BAG ADA', 'BAG BEKUM', 'URGUDANG'];
        $stats = \App\Models\BwsReport::whereRaw("strftime('%Y', created_at) = ?", [$selectedYear])
            ->select('bagian', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('bagian')
            ->pluck('total', 'bagian')
            ->toArray();

        $bwsStats = [];
        foreach ($bagianList as $bag) {
            $bwsStats[$bag] = $stats[$bag] ?? 0;
        }

        // Jenis laporan breakdown per bagian
        $jenisTypes = ['KORUPSI KOLUSI DAN NEPOTISME', 'PUNGUTAN LIAR', 'PENYALAHGUNAAN WEWENANG', 'PENYALAHGUNAAN NARKOBA', 'LAINNYA'];
        $jenisPerBagian = [];
        foreach ($bagianList as $bag) {
            foreach ($jenisTypes as $jenis) {
                $jenisPerBagian[$bag][$jenis] = \App\Models\BwsReport::whereRaw("strftime('%Y', created_at) = ?", [$selectedYear])
                    ->where('bagian', $bag)->where('jenis_laporan', $jenis)->count();
            }
        }

        // News stats: per month for selected year
        $newsMonthly = [];
        for ($month = 1; $month <= 12; $month++) {
            $count = \App\Models\News::whereRaw("strftime('%Y', created_at) = ?", [$selectedYear])
                ->whereRaw("strftime('%m', created_at) = ?", [sprintf('%02d', $month)])->count();
            $monthName = \Carbon\Carbon::create()->month($month)->translatedFormat('M');
            $newsMonthly[$monthName] = $count;
        }
        $totalNews = \App\Models\News::whereRaw("strftime('%Y', created_at) = ?", [$selectedYear])->count();

        // Document stats: per folder for selected year
        $folders = \App\Models\DocumentFolder::withCount(['documents' => function($q) use ($selectedYear) {
            $q->whereRaw("strftime('%Y', created_at) = ?", [$selectedYear]);
        }])->get();
        
        $docStats = [];
        foreach ($folders as $folder) {
            $docStats[$folder->name] = $folder->documents_count;
        }
        $totalDocs = \App\Models\Document::whereRaw("strftime('%Y', created_at) = ?", [$selectedYear])->count();

        return view('admin.dashboard', compact('bwsStats', 'jenisPerBagian', 'selectedYear', 'availableYears', 'newsMonthly', 'totalNews', 'docStats', 'totalDocs'));
    }

    // --- APPS CRUD ---
    public function appsIndex()
    {
        $apps = App::orderByRaw('urutan IS NULL, urutan ASC')->latest()->get();
        return view('admin.apps.index', compact('apps'));
    }

    public function appsCreate()
    {
        return view('admin.apps.create');
    }

    public function appsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'urutan' => 'nullable|integer',
            'url' => 'required|url',
            'icon' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('icon')) {
            $validated['icon'] = $request->file('icon')->store('thumbnails', 'public');
        }

        App::create($validated);
        return redirect()->route('admin.apps.index')->with('success', 'Aplikasi berhasil ditambahkan.');
    }

    public function appsEdit(App $app)
    {
        return view('admin.apps.edit', compact('app'));
    }

    public function appsUpdate(Request $request, App $app)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'urutan' => 'nullable|integer',
            'url' => 'required|url',
            'icon' => 'nullable|image|max:2048',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('icon')) {
            if ($app->icon) Storage::disk('public')->delete($app->icon);
            $validated['icon'] = $request->file('icon')->store('thumbnails', 'public');
        }

        $app->update($validated);
        return redirect()->route('admin.apps.index')->with('success', 'Aplikasi berhasil diupdate.');
    }

    public function appsDestroy(Request $request, App $app)
    {
        if ($app->icon) Storage::disk('public')->delete($app->icon);
        $app->delete();

        if ($request->has('from_profile')) {
            return redirect()->route('admin.profile-site.edit')->with(['success' => 'Aplikasi berhasil dihapus.', 'app_success' => true]);
        }

        return redirect()->route('admin.apps.index')->with('success', 'Aplikasi berhasil dihapus.');
    }

    // --- NEWS CRUD ---
    public function newsIndex()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function newsCreate()
    {
        return view('admin.news.create');
    }

    public function newsStore(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'instagram_url' => 'nullable|url',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        News::create($validated);
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function newsEdit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function newsUpdate(Request $request, News $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'instagram_url' => 'nullable|url',
        ]);

        if ($request->title !== $news->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        }

        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) Storage::disk('public')->delete($news->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $news->update($validated);
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diupdate.');
    }

    public function newsDestroy(News $news)
    {
        if ($news->thumbnail) Storage::disk('public')->delete($news->thumbnail);
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
    }

    // --- SITE PROFILE MANAGEMENT ---
    public function profileEdit()
    {
        $profile = \App\Models\Profile::first();
        return view('admin.profile.edit', compact('profile'));
    }

    public function profileUpdate(Request $request)
    {
        $profile = \App\Models\Profile::first();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'quote' => 'required|string',
            'vision' => 'required|string',
            'mission' => 'required|string',
            'about_short' => 'nullable|string',
            'history' => 'nullable|string',
            'values' => 'nullable|string',
            'years_of_service' => 'nullable|string',
            'integrity_service' => 'nullable|string',
            'ecosystem_description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'whatsapp' => 'nullable|string',
        ]);

        if ($request->has('whatsapp') && !empty($validated['whatsapp'])) {
            $validated['whatsapp'] = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $validated['whatsapp']));
        }

        if ($request->hasFile('photo')) {
            if ($profile->photo && $profile->photo !== 'pimpinan.png') {
                Storage::disk('public')->delete($profile->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profile', 'public');
        }

        $profile->update($validated);

        return redirect()->back()->with('success', 'Profil Berhasil Diperbarui.');
    }

    // --- LOGO MANAGEMENT ---
    public function logoEdit()
    {
        $profile = \App\Models\Profile::first();
        return view('admin.logo.edit', compact('profile'));
    }

    public function logoUpdate(Request $request)
    {
        $profile = \App\Models\Profile::first();
        
        $validated = $request->validate([
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($profile->logo) {
                Storage::disk('public')->delete($profile->logo);
            }
            $validated['logo'] = $request->file('logo')->store('profile', 'public');
        }

        $profile->update($validated);

        return redirect()->back()->with('success', 'Logo SILOGIS Berhasil Diperbarui.');
    }
}
