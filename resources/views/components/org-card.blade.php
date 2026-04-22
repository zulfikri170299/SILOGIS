<div class="org-card group flex flex-col items-center text-center w-full max-w-[180px] mx-auto">
    <!-- Photo Layer -->
    <div class="relative mb-3">
        <div class="absolute -inset-4 bg-brand-primary/5 blur-2xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
        <div class="relative h-36 w-28 md:h-44 md:w-32 rounded-xl overflow-hidden border-2 border-white shadow-lg group-hover:scale-105 group-hover:shadow-brand-primary/20 transition-all duration-500 bg-slate-100">
            @if($node->photo)
                <img src="{{ asset('storage/' . $node->photo) }}" class="h-full w-full object-cover" alt="{{ $node->name }}">
            @else
                <div class="h-full w-full flex items-center justify-center bg-slate-50 text-slate-200">
                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
            @endif
        </div>
    </div>

    <!-- Info Layer -->
    <div class="space-y-1">
        <h4 class="text-xs font-black text-slate-800 uppercase font-jakarta tracking-tight leading-snug group-hover:text-brand-primary transition-colors">
            {{ $node->rank }} {{ $node->name }}
        </h4>
        <div class="inline-block px-3 py-1 bg-slate-100 rounded-full text-[9px] font-bold text-slate-500 uppercase tracking-widest group-hover:bg-brand-primary group-hover:text-white transition-all">
            {{ $node->position }}
        </div>
    </div>
</div>
