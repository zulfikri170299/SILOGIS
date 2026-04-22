<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $appsCount = App::count();
        $newsCount = News::count();
        return view('admin.dashboard', compact('appsCount', 'newsCount'));
    }

    // --- APPS CRUD ---
    public function appsIndex()
    {
        $apps = App::latest()->get();
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
            'years_of_service' => 'nullable|string',
            'integrity_service' => 'nullable|string',
            'ecosystem_description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if it's not the default placeholder
            if ($profile->photo && $profile->photo !== 'pimpinan.png') {
                Storage::disk('public')->delete($profile->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profile', 'public');
        }

        $profile->update($validated);

        return redirect()->back()->with('success', 'Profil Berhasil Diperbarui.');
    }
}
