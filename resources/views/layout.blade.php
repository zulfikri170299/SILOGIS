<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SILOGIS | Biro Logistik Polda NTB</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            primary: '#0062ff',
                            light: '#f8fafc', // slate-50
                            dark: '#0f172a', // slate-900
                        }
                    },
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        outfit: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        ::selection { background: #0062ff; color: white; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #0062ff; }

        .floating-nav {
            position: fixed;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 4rem);
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 2rem;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08);
        }
        
        .nav-scrolled {
            top: 1rem;
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        }

        .dot-pattern {
            background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-slate-50 text-slate-800 antialiased selection:bg-brand-primary selection:text-white dot-pattern">
    <!-- Floating Island Navigation -->
    <nav id="main-nav" class="floating-nav">
        <div class="px-8 flex justify-between h-20 items-center">
            <a href="{{ route('portal.index') }}" class="flex items-center gap-4 group">
                <img src="{{ asset('log polri.png') }}" class="h-10 w-auto" alt="POLRI Logo">
                <div class="flex flex-col">
                    <span class="text-2xl font-black text-brand-primary italic leading-none font-outfit uppercase tracking-[0.2em]">SILOGIS</span>
                </div>
            </a>
            
            <!-- Desktop Links -->
            <div class="hidden lg:flex items-center gap-10">
                <div class="flex items-center gap-8">
                    @php $links = ['Beranda' => '/', 'Layanan' => '#layanan', 'Berita' => '#berita', 'Struktur' => '#struktur']; @endphp
                    @foreach($links as $name => $url)
                        <a href="{{ $url }}" class="text-[11px] font-bold text-slate-500 hover:text-brand-primary uppercase tracking-widest transition-all">{{ $name }}</a>
                    @endforeach
                </div>
                
                <div class="h-6 w-px bg-slate-200"></div>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="bg-brand-primary text-white hover:bg-brand-dark hover:text-white px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all shadow-lg shadow-brand-primary/20 italic">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-slate-100 text-slate-700 hover:bg-brand-primary hover:text-white px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all italic">Login Access</a>
                @endauth
            </div>

            <!-- Mobile Menu Btn -->
            <button class="lg:hidden p-2 text-slate-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </nav>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Elite Footer Light -->
    <footer class="bg-white py-24 border-t border-slate-200 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-20">
                <div class="col-span-2">
                    <div class="flex items-center gap-4 mb-8">
                        <img src="{{ asset('log polri.png') }}" class="h-12 w-auto" alt="">
                        <div class="flex flex-col">
                            <span class="text-4xl font-black text-slate-800 italic uppercase font-outfit tracking-[0.2em]">SILOGIS</span>
                        </div>
                    </div>
                    <p class="text-slate-500 text-lg leading-relaxed max-w-md font-medium">
                        Platform logistik terintegrasi dengan standar keamanan tinggi dan transparansi operasional melalui modernisasi digital berkelanjutan.
                    </p>
                </div>
                <div>
                    <h4 class="text-slate-800 font-black uppercase tracking-widest text-xs mb-8 italic">Visi Kami</h4>
                    <p class="text-sm text-slate-500 leading-relaxed font-bold italic">
                        {{ $profile->vision ?? 'Menjadi Biro Logistik yang Modern, Profesional, dan Terpercaya dalam Mendukung Operasional Kepolisian NTB.' }}
                    </p>
                </div>
                <div>
                    <h4 class="text-slate-800 font-black uppercase tracking-widest text-xs mb-8 italic">Misi Kami</h4>
                    <div class="text-sm text-slate-500 leading-relaxed font-bold italic space-y-2">
                         {!! nl2br(e($profile->mission ?? 'Penyelenggaraan Manajemen Aset yang Transparan.
Pengembangan Infrastruktur Digital Logistik.
Peningkatan Layanan Dukungan Personel.')) !!}
                    </div>
                </div>
            </div>
            <div class="pt-20 mt-20 border-t border-slate-100 flex flex-col md:flex-row justify-between items-center gap-8 text-[10px] font-black uppercase tracking-widest text-slate-400">
                <p>&copy; {{ date('Y') }} Bureau of Logistics NTB Regional Police. All rights reserved.</p>
                <div class="flex gap-10">
                    <a href="#" class="hover:text-brand-primary transition-colors">Official Website</a>
                    <a href="#" class="hover:text-brand-primary transition-colors">Legal Info</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('main-nav');
            if (window.scrollY > 50) {
                nav.classList.add('nav-scrolled');
            } else {
                nav.classList.remove('nav-scrolled');
            }
        });
    </script>
</body>
</html>
