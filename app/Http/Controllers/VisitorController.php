<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class VisitorController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nama' => 'required|string|max:255',
            'satuan_kerja' => 'nullable|string|max:255',
        ]);

        $visitor = Visitor::where('email', $request->email)->first();

        if (!$visitor) {
            $visitor = Visitor::create([
                'email' => $request->email,
                'nama' => $request->nama,
                'satuan_kerja' => $request->satuan_kerja,
            ]);
        } else {
            // Update nama/satker in case they want to change it, or just leave it. 
            // We'll update it to keep it fresh.
            $visitor->update([
                'nama' => $request->nama,
                'satuan_kerja' => $request->satuan_kerja,
            ]);
        }

        VisitorLog::create([
            'visitor_id' => $visitor->id,
            'visited_at' => now(),
        ]);

        // Set session so we don't log them again in this session
        session(['visitor_logged_in' => true]);

        // Set cookie for 1 year (525600 minutes)
        Cookie::queue('visitor_email', $visitor->email, 525600);

        return redirect()->route('portal.index')->with('success', 'Selamat datang, ' . $visitor->nama . '!');
    }
}
