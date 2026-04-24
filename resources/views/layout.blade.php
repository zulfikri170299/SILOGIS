<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SILOGIS | Biro Logistik Polda NTB</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;600;700;800;900&family=Russo+One&family=Bungee&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        [x-cloak] { display: none !important; }
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
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.08);
        }
        
        .nav-scrolled {
            top: 1rem;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(0, 98, 255, 0.15);
            box-shadow: 0 25px 50px -12px rgba(0, 98, 255, 0.1);
        }

        .nav-link {
            position: relative;
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
        }
        .nav-link:hover { color: #0062ff; }
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 50%;
            width: 0;
            height: 2px;
            background: #0062ff;
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }
        .nav-link:hover::after { width: 100%; }
        
        /* Active State */
        .nav-link.active { color: #0062ff; }
        .nav-link.active::after { width: 100%; }


        .dot-pattern {
            background-image: radial-gradient(#cbd5e1 1.5px, transparent 1.5px);
            background-size: 24px 24px;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-float { animation: float 4s ease-in-out infinite; }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }
        .shimmer-effect {
            background: linear-gradient(90deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        .mesh-gradient {
            background: radial-gradient(at 0% 0%, rgba(0, 98, 255, 0.1) 0, transparent 50%),
                        radial-gradient(at 50% 0%, rgba(255, 230, 0, 0.05) 0, transparent 50%),
                        radial-gradient(at 100% 0%, rgba(255, 0, 0, 0.05) 0, transparent 50%);
        }

        .glass-premium {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal-on-scroll.active {
            opacity: 1;
            transform: translateY(0);
        }

        .elite-3d-red {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            background: linear-gradient(to bottom, #ef4444 0%, #7f1d1d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 4px 10px rgba(127, 29, 29, 0.2));
            letter-spacing: 0.1em;
        }

        .elite-3d-yellow {
            font-family: 'Outfit', sans-serif;
            font-weight: 900;
            background: linear-gradient(to bottom, #fbbf24 0%, #92400e 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 4px 10px rgba(146, 64, 14, 0.2));
            letter-spacing: 0.1em;
        }

        /* Floating WA Style */
        .wa-floating {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 70px;
            height: 70px;
            background: #25d366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            box-shadow: 0 10px 40px rgba(37, 211, 102, 0.4);
            z-index: 9999;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .wa-floating:hover {
            transform: scale(1.1) rotate(10deg);
            background: #128c7e;
            box-shadow: 0 15px 50px rgba(37, 211, 102, 0.6);
        }

        .wa-pulse {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #25d366;
            animation: pulse-wa 2s infinite;
            z-index: -1;
            opacity: 0.6;
        }

        @keyframes pulse-wa {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.6); opacity: 0; }
        }

        @keyframes elite-text-shimmer {
            0% { background-position: 100% center; }
            100% { background-position: -100% center; }
        }

        .elite-shimmer-effect {
            background: linear-gradient(
                to right, 
                #dc2626 0%, 
                #eab308 45%, 
                #ffffff 50%, 
                #eab308 55%, 
                #dc2626 100%
            );
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: elite-text-shimmer 15s infinite linear;
        }
        [x-cloak] { display: none !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ activeSection: 'beranda' }" class="font-sans bg-slate-50 text-slate-800 antialiased selection:bg-brand-primary selection:text-white dot-pattern">
    <!-- Floating Island Navigation -->
    <nav id="main-nav" class="floating-nav">
        <div class="px-8 flex justify-between h-20 items-center">
            <a href="#" @click.prevent="activeSection = 'beranda'" class="flex items-center gap-4 group">
                <img src="{{ asset('log polri.png') }}" class="h-10 w-auto" alt="POLRI Logo">
                <div class="flex flex-col">
                    <span class="text-2xl font-black italic leading-none font-outfit uppercase tracking-[0.2em] bg-gradient-to-r from-red-600 via-yellow-500 to-black bg-clip-text text-transparent">SILOGIS</span>
                    <span class="text-[8px] font-black text-slate-500 uppercase tracking-[0.1em] mt-1">Sistem Informasi Logistik</span>
                </div>
            </a>
            
            <!-- Desktop Links -->
            <div class="hidden lg:flex items-center gap-10">
                <div class="flex items-center gap-8">
                    @php 
                        $links = [
                            'Beranda' => 'beranda', 
                            'Layanan' => 'layanan', 
                            'Berita' => 'berita', 
                            'Dokumen' => 'dokumen', 
                            'Struktur' => 'struktur',
                            'Bagian/Fungsi' => 'bagian'
                        ]; 
                    @endphp
                    @foreach($links as $name => $id)
                        <a href="#" 
                           @click.prevent="activeSection = '{{ $id }}'" 
                           :class="{ 'active': activeSection === '{{ $id }}' }"
                           class="nav-link">{{ $name }}</a>
                    @endforeach
                </div>
                
                <div class="h-6 w-px bg-slate-200"></div>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="bg-brand-primary text-white hover:bg-brand-dark hover:text-white px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all shadow-lg shadow-brand-primary/20 italic">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-[#800000] text-white hover:bg-red-900 px-8 py-3 rounded-xl text-[11px] font-black uppercase tracking-widest transition-all italic shadow-lg shadow-red-900/20">Login Access</a>
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

    <!-- Footer Removed -->
    
    <!-- Floating WA Button -->
    @php
        $waNumber = $profile->whatsapp ?? '6281234567890';
        $waNumber = preg_replace('/[^0-9]/', '', $waNumber);
        $waNumber = preg_replace('/^0/', '62', $waNumber);
    @endphp
    <a href="https://api.whatsapp.com/send?phone={{ $waNumber }}&text=Halo%20Admin%20Silogis,%20saya%20ingin%20konsultasi..." target="_blank" class="wa-floating group" title="Konsultasi via WhatsApp">
        <div class="wa-pulse"></div>
        <svg class="w-10 h-10 transition-transform group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 .004 5.408.001 12.045a11.815 11.815 0 001.591 5.976L0 24l6.135-1.61a11.803 11.803 0 005.911 1.586h.005c6.635 0 12.045-5.408 12.048-12.047a11.8 11.8 0 00-3.543-8.514z"/>
        </svg>
        <span class="absolute right-full mr-4 bg-white text-[#128c7e] px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest pointer-events-none opacity-0 group-hover:opacity-100 transition-all transform translate-x-4 group-hover:translate-x-0 shadow-xl whitespace-nowrap">Ayo Konsultasi</span>
    </a>

    <script>
        // Scroll Management
        window.addEventListener('scroll', () => {
            const nav = document.getElementById('main-nav');
            if (window.scrollY > 100) {
                nav.classList.add('nav-scrolled');
            } else {
                nav.classList.remove('nav-scrolled');
            }
        });

        // Initialize on Load
        document.addEventListener('DOMContentLoaded', () => {
            // Intersection Observer for Reveal
            const observerOptions = { threshold: 0.1 };
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
