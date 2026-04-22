<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\News;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        $apps = App::all();
        $news = News::latest()->take(8)->get();
        $profile = \App\Models\Profile::first(['*']);
        $organograms = \App\Models\Organogram::whereNull('parent_id')->with('children.children.children')->orderBy('order')->get();
        
        return view('index', compact('apps', 'news', 'profile', 'organograms'));
    }

    public function show(News $news)
    {
        $profile = \App\Models\Profile::first();
        return view('news.show', compact('news', 'profile'));
    }
}
