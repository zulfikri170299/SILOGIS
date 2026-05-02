<!-- MOBILE PROFILE HEADER -->
<div class="md:hidden bg-white px-6 pt-8 pb-4 flex items-center justify-between relative z-50">
    <div class="flex items-center gap-4">
        <!-- Avatar/Profile Pic -->
        <div class="relative">
            <div class="w-12 h-12 rounded-full border-2 border-brand-primary p-0.5 overflow-hidden shadow-lg shadow-brand-primary/10">
                @if(isset($profile) && $profile->image)
                    <img src="{{ asset('storage/' . $profile->image) }}" class="w-full h-full object-cover rounded-full" alt="Profile">
                @else
                    <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                @endif
            </div>
            <!-- Online status indicator -->
            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
        </div>

        <!-- Greeting -->
        <div class="flex flex-col">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none mb-1">Halo,</span>
            <h2 class="text-sm font-black text-slate-800 uppercase font-outfit tracking-tight">
                {{ auth()->user()->name ?? 'PENGUNJUNG' }}
            </h2>
        </div>
    </div>

    <!-- Notification Bell -->
    <div class="relative">
        <button class="h-10 w-10 flex items-center justify-center rounded-2xl bg-slate-50 border border-slate-100 text-slate-500 hover:bg-slate-100 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        </button>
        <!-- Unread badge -->
        <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 border-2 border-white rounded-full flex items-center justify-center">
            <span class="text-[8px] font-black text-white">2</span>
        </div>
    </div>
</div>
