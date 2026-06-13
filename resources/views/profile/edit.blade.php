@extends('admin.layout')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="space-y-8">
        
        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
            <div class="bg-slate-900 px-8 py-6 flex justify-between items-center border-b border-white/5">
                <h2 class="text-white font-black italic tracking-tight flex items-center gap-3 font-outfit uppercase">
                    <svg class="h-5 w-5 text-brand-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    Tentang Profil
                </h2>
            </div>
            <div class="p-8 profile-form-wrapper">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="bg-slate-900/50 backdrop-blur-2xl rounded-3xl border border-white/5 shadow-2xl overflow-hidden">
            <div class="bg-slate-900 px-8 py-6 flex justify-between items-center border-b border-white/5">
                <h2 class="text-white font-black italic tracking-tight flex items-center gap-3 font-outfit uppercase">
                    <svg class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                    Keamanan Akun
                </h2>
            </div>
            <div class="p-8 profile-form-wrapper">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="bg-rose-950/20 backdrop-blur-2xl rounded-3xl border border-rose-500/20 shadow-2xl overflow-hidden">
            <div class="bg-rose-900/40 px-8 py-6 flex justify-between items-center border-b border-rose-500/20">
                <h2 class="text-rose-500 font-black italic tracking-tight flex items-center gap-3 font-outfit uppercase">
                    <svg class="h-5 w-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                    Hapus Akun
                </h2>
            </div>
            <div class="p-8 profile-form-wrapper-danger">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling overrides for default forms inside the dark theme */
    .profile-form-wrapper section > header > h2 { color: white !important; font-weight: 900; font-style: italic; text-transform: uppercase; letter-spacing: 0.1em; font-size: 14px; }
    .profile-form-wrapper section > header > p { color: #94a3b8 !important; font-size: 11px; margin-bottom: 2rem; font-weight: 700; }
    .profile-form-wrapper label { color: #64748b !important; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; }
    .profile-form-wrapper input { background-color: rgba(30, 41, 59, 0.5) !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; color: white !important; border-radius: 1rem; padding: 0.75rem 1rem; font-size: 12px; font-weight: 700; box-shadow: none !important; }
    .profile-form-wrapper input:focus { border-color: #f59e0b !important; outline: none; }
    .profile-form-wrapper button { background-color: #dc2626 !important; color: white !important; text-transform: uppercase; font-weight: 900; letter-spacing: 0.1em; font-size: 10px; border-radius: 9999px; padding: 0.75rem 2rem; transition: all 0.2s; border: none; }
    .profile-form-wrapper button:hover { background-color: #b11d1d !important; transform: scale(1.05); }

    .profile-form-wrapper-danger section > header > h2 { color: #f43f5e !important; font-weight: 900; font-style: italic; text-transform: uppercase; letter-spacing: 0.1em; font-size: 14px; }
    .profile-form-wrapper-danger section > header > p { color: #fb7185 !important; font-size: 11px; margin-bottom: 2rem; font-weight: 700; }
    .profile-form-wrapper-danger label { color: #f43f5e !important; font-size: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: 0.1em; }
    .profile-form-wrapper-danger input { background-color: rgba(136, 19, 55, 0.3) !important; border: 1px solid rgba(244, 63, 94, 0.3) !important; color: white !important; border-radius: 1rem; padding: 0.75rem 1rem; font-size: 12px; font-weight: 700; box-shadow: none !important; }
    .profile-form-wrapper-danger input:focus { border-color: #f43f5e !important; outline: none; }
    .profile-form-wrapper-danger button { background-color: #e11d48 !important; color: white !important; text-transform: uppercase; font-weight: 900; letter-spacing: 0.1em; font-size: 10px; border-radius: 9999px; padding: 0.75rem 2rem; transition: all 0.2s; border: none; }
    .profile-form-wrapper-danger button:hover { background-color: #be123c !important; transform: scale(1.05); }
    .profile-form-wrapper-danger button[x-on\:click] { background-color: rgba(255,255,255,0.1) !important; border: 1px solid rgba(255,255,255,0.2) !important; color: white !important;}
    .profile-form-wrapper-danger button[x-on\:click]:hover { background-color: rgba(255,255,255,0.2) !important; }
    
    /* Modal inside delete user form */
    .profile-form-wrapper-danger .fixed.inset-0.bg-gray-500 { background-color: rgba(15, 23, 42, 0.9) !important; backdrop-filter: blur(8px); }
    .profile-form-wrapper-danger .bg-white.rounded-lg { background-color: #1e293b !important; border: 1px solid rgba(255,255,255,0.1); border-radius: 2rem !important; }
    .profile-form-wrapper-danger h2.text-lg { color: white !important; font-weight: 900; font-style: italic; text-transform: uppercase; letter-spacing: 0.05em; }
    .profile-form-wrapper-danger p.text-gray-600 { color: #94a3b8 !important; }
</style>
@endsection
