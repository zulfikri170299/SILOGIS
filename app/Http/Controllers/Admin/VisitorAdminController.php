<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::withCount('logs')
            ->with(['logs' => function ($query) {
                $query->latest('visited_at');
            }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('satuan_kerja', 'like', "%{$search}%");
        }

        $visitors = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.visitors.index', compact('visitors'));
    }

    public function print(Request $request)
    {
        $query = Visitor::withCount('logs')
            ->with(['logs' => function ($query) {
                $query->latest('visited_at');
            }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('satuan_kerja', 'like', "%{$search}%");
        }

        $visitors = $query->orderByDesc('created_at')->get();

        return view('admin.visitors.print', compact('visitors'));
    }
}
