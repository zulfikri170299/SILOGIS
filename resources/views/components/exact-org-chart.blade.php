@php
    function getNode($p) {
        return \App\Models\Organogram::where('position', $p)->first();
    }
    
    function renderOrgBox($node, $defaultPosition, $bgClass = 'bg-[#dc2626]', $wClass = 'w-48') {
        $svgUser = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-full h-full p-1 opacity-20"><path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" /></svg>';
        
        $photoHTML = '';
        if($node && $node->photo) {
            $photoHTML = '<img src="'.asset('storage/'.$node->photo).'" class="w-full h-full object-cover">';
        } else {
            $photoHTML = '<div class="w-full h-full flex items-center justify-center text-slate-400">FOTO</div>';
        }
        
        $pos = $node ? $node->position : $defaultPosition;
        $name = $node && $node->name ? $node->name : '-';
        $rank = $node && $node->rank ? $node->rank : '-';
        
        return '
        <div class="org-card-wrapper inline-block z-10 relative transition-all duration-300 hover:-translate-y-1 group mx-0.5">
            <div class="flex flex-col '.$wClass.' bg-white rounded shadow-[0_2px_8px_rgba(0,0,0,0.05)] border border-slate-200 overflow-hidden mx-auto">
                <!-- Header -->
                <div class="'.$bgClass.' text-white font-extrabold py-1 px-1 text-center text-[8px] md:text-[9px] tracking-tight shadow-sm z-10 relative uppercase leading-tight truncate px-1">
                    ' . htmlspecialchars($pos) . '
                </div>
                
                <!-- Body -->
                <div class="flex items-stretch bg-white">
                    <!-- Photo Col -->
                    <div class="w-[30%] bg-[#f8fafc] flex items-center justify-center p-1 border-r border-slate-100 shrink-0">
                        <div class="w-full aspect-[3/4] rounded-sm overflow-hidden bg-white border border-slate-200 text-[6px] font-bold text-slate-400">
                            ' . $photoHTML . '
                        </div>
                    </div>
                    
                    <!-- Info Col -->
                    <div class="w-[70%] flex flex-col justify-center bg-white shrink-0">
                        <div class="py-1 px-1 text-[8px] md:text-[9px] font-black text-slate-800 text-center uppercase tracking-tight leading-none break-words line-clamp-2">
                            ' . htmlspecialchars($name) . '
                        </div>
                        <div class="w-4/5 mx-auto border-t-[0.5px] border-slate-100"></div>
                        <div class="py-1 px-1 text-[7px] font-bold text-slate-500 text-center uppercase tracking-tighter leading-none truncate">
                            ' . htmlspecialchars($rank) . '
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
@endphp

<div class="org-container relative mx-auto pb-10 pt-3 px-2 w-full flex justify-center overflow-x-hidden min-w-fit" style="font-family: 'Outfit', sans-serif;">
    <style>
        /* CSS Tree Layout - Extra Compact */
        .tree { display: flex; justify-content: center; }
        .tree ul { padding-top: 10px; position: relative; transition: all 0.5s; display: flex; }
        .tree li { float: left; text-align: center; list-style-type: none; position: relative; padding: 10px 0 0 0; transition: all 0.5s; }
        
        .tree li::before, .tree li::after { content: ''; position: absolute; top: 0; right: 50%; border-top: 1.5px solid #94a3b8; width: 50%; height: 10px; }
        .tree li::after { right: auto; left: 50%; border-left: 1.5px solid #94a3b8; }
        
        .tree li:only-child::after, .tree li:only-child::before { display: none; }
        .tree li:only-child { padding-top: 0; }
        
        .tree li:first-child::before, .tree li:last-child::after { border: 0 none; }
        .tree li:last-child::before { border-right: 1.5px solid #94a3b8; border-radius: 0; right: 50%; width: 50%; }
        
        .tree ul ul::before { content: ''; position: absolute; top: 0; left: 50%; border-left: 1.5px solid #94a3b8; width: 0; height: 10px; transform: translateX(-50%); }

        .trunk-line { width: 1.5px; background: #94a3b8; height: 25px; margin: 0 auto; position: relative; z-index: 5; }
        .bypass-line { width: 1.5px; background: #94a3b8; position: absolute; left: 50%; top: 60px; bottom: -15px; transform: translateX(-50%); z-index: 1; }
    </style>

    @php 
        $trunkOffset = 'translate-x-16'; 
        $trunkLeft = 'left-1/2';
    @endphp

    <div class="flex flex-col items-center w-full relative">
        <!-- THE CONTINUOUS MAIN TRUNK (Background layer to ensure no breaks) -->
        <!-- Starts below Karolog, ends at Gudang -->
        <div class="absolute {{ $trunkLeft }} {{ $trunkOffset }} w-[2px] bg-[#94a3b8] z-0" style="top: 80px; bottom: 80px; margin-left: -1px;"></div>

        <!-- KAROLOG -->
        @php $karolog = getNode('KAROLOG POLDA NTB'); @endphp
        <div class="{{ $trunkOffset }} z-20 relative">
            {!! renderOrgBox($karolog, 'KAROLOG POLDA NTB', 'bg-[#dc2626]', 'w-[18rem]') !!}
        </div>

        <!-- Vertical Space for Renmin branch -->
        <div class="h-[60px]"></div>

        <!-- SPECIAL ROW: Lateral branch for RENMIN -->
        <div class="flex items-start w-full justify-center relative min-h-[140px]">
             <!-- Spacer Left -->
             <div class="w-1/2"></div>
             
             <!-- Branch Right -->
             <div class="w-1/2 relative flex justify-start">
                  <!-- The horizontal connector -->
                  <div class="absolute top-0 {{ $trunkOffset }} w-[15%] h-[2px] bg-[#94a3b8]"></div>
                  <!-- The vertical drop into Renmin -->
                  <div class="absolute top-0 {{ $trunkOffset }} left-[15%] w-[2px] h-[15px] bg-[#94a3b8]"></div>
                  
                  <div class="pl-[15%] {{ $trunkOffset }} flex flex-col items-center relative z-10 -mt-2">
                       <div class="tree pb-10">
                            <ul class="!p-0">
                                <li class="!p-0 before:!hidden after:!hidden">
                                    @php $renmin = getNode('KASUBBAG RENMIN'); @endphp
                                    {!! renderOrgBox($renmin, 'KASUBBAG RENMIN', 'bg-[#0284c7]', 'w-[14rem]') !!}
                                    <ul class="relative before:!h-4">
                                        <li>
                                            @php $ren = getNode('KAUR REN'); @endphp
                                            {!! renderOrgBox($ren, 'KAUR REN', 'bg-[#475569]', 'w-[9rem]') !!}
                                        </li>
                                        <li>
                                            @php $mintu = getNode('KAUR MINTU'); @endphp
                                            {!! renderOrgBox($mintu, 'KAUR MINTU', 'bg-[#475569]', 'w-[9rem]') !!}
                                        </li>
                                        <li>
                                            @php $keu = getNode('KAUR KEU'); @endphp
                                            {!! renderOrgBox($keu, 'KAUR KEU', 'bg-[#475569]', 'w-[9rem]') !!}
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                       </div>
                  </div>
             </div>
        </div>

        <!-- KABAG Level -->
        <div class="tree relative w-full pt-10">
            <ul class="relative flex justify-center w-full !pt-0">
                <!-- THE SOLID HORIZONTAL CONNECTOR (Spans the whole row) -->
                <div class="absolute top-0 left-0 right-0 h-[2px] bg-[#94a3b8] mx-[10%]"></div>

                @php
                    $kabags = [
                        ['KABAG ADA', 'KSB LP', 'KSB LPSE'],
                        ['KABAG INFOLOG', 'KSB PBMN', 'KSB KESJAS'],
                        ['KABAG BEKUM', 'KSB BBMP', 'KSB KAPSINTOR'],
                        ['KABAG PAL', 'KSB ALSUSANG', 'KSB SENMU'],
                        ['KABAG FASKON', 'KSB KONBANGTA', 'KSB PRASENTAL']
                    ];
                @endphp
                @foreach($kabags as $index => $k)
                    @php $kabNode = getNode($k[0]); @endphp
                    
                    <li class="relative px-3 !pt-0 before:!hidden after:!hidden flex flex-col items-center">
                        <!-- Connector to the horizontal line above -->
                        <div class="w-[2px] h-4 bg-[#94a3b8]"></div>
                        {!! renderOrgBox($kabNode, $k[0], 'bg-[#0ea5e9]', 'w-[12rem]') !!}

                        <ul class="relative before:!h-4">
                            <li class="!pt-4 before:!h-4 after:!h-4">
                                @php $c1 = getNode($k[1]); @endphp
                                {!! renderOrgBox($c1, $k[1], 'bg-[#475569]', 'w-[5.8rem]') !!}
                            </li>
                            <li class="!pt-4 before:!h-4 after:!h-4">
                                @php $c2 = getNode($k[2]); @endphp
                                {!! renderOrgBox($c2, $k[2], 'bg-[#475569]', 'w-[5.8rem]') !!}
                            </li>
                        </ul>
                    </li>

                    <!-- CENTRAL TRUNK GAP (Matches Karolog Offset) -->
                    @if($index == 2)
                        <li class="relative w-28 flex justify-center items-start {{ $trunkOffset }} !pt-0 before:!hidden after:!hidden">
                            <!-- Vertical segment passing through -->
                            <div class="w-[2px] bg-[#94a3b8] h-full absolute top-0 left-1/2 -ml-[1px] z-0"></div>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <!-- Space to Gudang -->
        <div class="h-10"></div>

        <!-- KAUR GUDANG -->
        @php $gudang = getNode('KAUR GUDANG'); @endphp
        <div class="relative {{ $trunkOffset }} z-10">
            {!! renderOrgBox($gudang, 'KAUR GUDANG', 'bg-[#10b981]', 'w-[18rem]') !!}
        </div>
    </div>
</div>
