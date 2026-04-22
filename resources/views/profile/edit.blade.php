@extends('admin.layout')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden p-8">
        <div class="max-w-xl">
            <h3 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tight italic">Tentang Profil</h3>
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden p-8">
        <div class="max-w-xl">
             <h3 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tight italic">Keamanan Akun</h3>
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="bg-rose-50 rounded-3xl border border-rose-100 shadow-sm overflow-hidden p-8">
        <div class="max-w-xl">
             <h3 class="text-lg font-black text-rose-900 mb-6 uppercase tracking-tight italic">Hapus Akun</h3>
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
