<a href="{{ route('admin.dashboard') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
    Dashboard Utama
</a>

<div class="mt-6 mb-2 px-3 text-[9px] font-black uppercase tracking-widest text-slate-500">Managemen Data</div>

<a href="{{ route('admin.apps.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.apps.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
    Katalog Aplikasi
</a>

<a href="{{ route('admin.news.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.news.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5L18.5 7H20" /></svg>
    Kelola Berita
</a>

<a href="{{ route('admin.document-folders.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.document-folders.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
    Folder Dokumen
</a>

<a href="{{ route('admin.documents.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.documents.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
    Kelola Dokumen
</a>

<a href="{{ route('admin.organograms.index') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.organograms.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
    Struktur Organisasi
</a>

<div class="mt-6 mb-2 px-3 text-[9px] font-black uppercase tracking-widest text-slate-500">Pengaturan</div>

<a href="{{ route('admin.profile-site.edit') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('admin.profile-site.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
    Edit Profil Beranda
</a>

<a href="{{ route('profile.edit') }}" 
   class="group flex items-center gap-x-2.5 rounded-xl p-2.5 text-xs font-bold leading-6 transition-all {{ request()->routeIs('profile.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
    <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
    Profil Saya
</a>
