<div class="org-node flex flex-col items-center">
    <!-- Card -->
    <div class="org-card bg-white p-4 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.08)] border-t-4 border-brand-primary min-w-[200px] max-w-[240px] text-center relative z-10 transition-transform duration-300 hover:-translate-y-2">
        @if($node->photo)
            <div class="w-16 h-16 mx-auto rounded-full overflow-hidden border-2 border-slate-100 mb-3 shadow-md">
                <img src="{{ asset('storage/' . $node->photo) }}" class="w-full h-full object-cover">
            </div>
        @else
            <div class="w-16 h-16 mx-auto rounded-full overflow-hidden border-2 border-slate-100 mb-3 shadow-md bg-slate-100 flex items-center justify-center text-slate-400">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
        @endif
        
        <h4 class="font-black text-slate-800 text-[11px] uppercase tracking-widest leading-tight mb-1">{{ $node->position }}</h4>
        @if($node->name)
            <p class="text-brand-primary text-[10px] font-bold italic">{{ $node->name }}</p>
        @endif
        @if($node->rank)
            <p class="text-slate-500 text-[9px] font-bold uppercase mt-1">{{ $node->rank }}</p>
        @endif
    </div>

    @if($node->children->count() > 0)
        <!-- Line Down from Parent -->
        <div class="w-px h-8 bg-brand-primary/40 relative"></div>
        
        <div class="org-children flex gap-6 relative">
            <!-- Horizontal Line Connecting Children -->
            @if($node->children->count() > 1)
                <div class="absolute top-0 left-0 w-full h-px bg-brand-primary/40" style="left: calc((100% / {{ $node->children->count() }} / 2)); width: calc(100% - (100% / {{ $node->children->count() }}));"></div>
            @endif
            
            @foreach($node->children as $child)
                <div class="org-child relative pt-8 flex flex-col items-center flex-1">
                    <!-- Line Down to Child -->
                    <div class="absolute top-0 left-1/2 w-px h-8 bg-brand-primary/40 -translate-x-1/2"></div>
                    
                    <!-- Recursive Include -->
                    @include('components.org-node', ['node' => $child])
                </div>
            @endforeach
        </div>
    @endif
</div>
