<a href="{{ route('admin.dashboard') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
    Dashboard Utama
</a>

<div class="mt-6 mb-2 px-3 text-[9px] font-black uppercase tracking-widest text-slate-500">Managemen Data</div>

@if(!Auth::user()->isAdminBag())
<a href="{{ route('admin.news.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.news.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20" /></svg>
    Kelola Berita
</a>
@endif

<a href="{{ route('admin.bws.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.bws.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
    Pengaduan WBS
</a>

@if(!Auth::user()->isAdminBag())
<a href="{{ route('admin.document-folders.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.document-folders.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
    Folder Dokumen
</a>

<a href="{{ route('admin.documents.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.documents.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
    Kelola Dokumen
</a>

<a href="{{ route('admin.organograms.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.organograms.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
    Struktur Organisasi
</a>
@endif

@if(Auth::user()->isSuperAdmin())
<div class="mt-6 mb-2 px-3 text-[9px] font-black uppercase tracking-widest text-slate-500">Sistem & Akses</div>

<a href="{{ route('admin.apps.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.apps.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
    Kelola Aplikasi
</a>

<a href="{{ route('admin.users.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.users.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
    Kelola Pengguna
</a>

<a href="{{ route('admin.bagians.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.bagians.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
    Kelola Bagian
</a>
@endif

@if(!Auth::user()->isAdminBag())
<div class="mt-6 mb-2 px-3 text-[9px] font-black uppercase tracking-widest text-slate-500">Pengaturan</div>

<a href="{{ route('admin.profile-site.edit') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.profile-site.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
    Edit Profil Beranda
</a>

<a href="{{ route('admin.logo.edit') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.logo.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
    Menu Setting
</a>
@endif

<a href="{{ route('profile.edit') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('profile.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
    Profil Saya
</a>
