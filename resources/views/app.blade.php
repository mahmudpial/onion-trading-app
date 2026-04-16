<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — OnionTrade Pro</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/oniontrade-icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('brand/oniontrade-icon-180.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap"
        rel="stylesheet">

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        syne: ['Syne', 'sans-serif'],
                        sans: ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        bg: '#0f1a12',
                        surface: '#162019',
                        surface2: '#1e2d22',
                        surface3: '#243329',
                        border: '#2a3d2f',
                        green: {
                            DEFAULT: '#4ade80',
                            dim: '#22c55e',
                            muted: '#166534',
                            dark: '#14532d',
                        },
                        accent: '#86efac',
                        textdim: '#9ab09e',
                        textmuted: '#5a7560',
                    }
                }
            }
        }
    </script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js" defer></script>

    {{-- Alpine.js (এই স্ক্রিপ্টটি ফাইল আপলোড এবং ইন্টারেকশনের জন্য অবশ্যই দরকার) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background: #0f1a12;
        }

        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #2a3d2f;
            border-radius: 4px;
        }

        .nav-item.active {
            background: linear-gradient(135deg, rgba(74, 222, 128, .15), rgba(74, 222, 128, .05));
        }

        .card-glow:hover {
            box-shadow: 0 0 40px rgba(74, 222, 128, .12);
        }

        .btn-primary {
            background: linear-gradient(135deg, #4ade80, #16a34a);
        }

        .btn-primary:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        @media(max-width:768px) {
            #sidebar {
                transform: translateX(-100%);
                transition: .3s;
            }

            #sidebar.open {
                transform: translateX(0);
            }
        }

        @media(max-width:480px) {
            #toast-wrap {
                right: 10px !important;
                left: 10px;
                bottom: 10px !important;
            }
        }

        @keyframes toastIn {
            from {
                transform: translateX(20px);
                opacity: 0
            }

            to {
                transform: translateX(0);
                opacity: 1
            }
        }
    </style>

    @stack('styles')
</head>

<body class="font-sans text-green-50 min-h-screen" style="background:#0f1a12">

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed left-0 top-0 bottom-0 w-60 flex flex-col z-50"
        style="background:#162019; border-right:1px solid #2a3d2f">
        <div class="p-5" style="border-bottom:1px solid #2a3d2f">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl font-bold"
                    style="background:linear-gradient(135deg,#4ade80,#16a34a);box-shadow:0 4px 15px rgba(74,222,128,.3)">
                    <img src="{{ asset('brand/oniontrade-icon.svg') }}" alt="OnionTrade Icon" class="w-6 h-6">
                </div>
                <div>
                    <div class="font-syne font-black text-sm text-green-50">OnionTrade</div>
                    <div class="text-xs tracking-widest uppercase" style="color:#5a7560">Pro Platform</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto p-3 space-y-0.5">
            <p class="px-2 pt-4 pb-1 text-xs font-semibold tracking-widest uppercase" style="color:#5a7560">Main</p>
            <a href="{{ route('dashboard') }}"
                class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'active text-green-400 border' : 'text-textdim hover:text-green-50' }}">📊
                Dashboard</a>
            <a href="{{ route('compare.index') }}"
                class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('compare.*') ? 'active text-green-400 border' : 'text-textdim hover:text-green-50' }}">⚖️
                দাম তুলনা</a>

            <p class="px-2 pt-5 pb-1 text-xs font-semibold tracking-widest uppercase" style="color:#5a7560">Manage</p>
            <a href="{{ route('markets.index') }}"
                class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('markets.*') ? 'active text-green-400 border' : 'text-textdim hover:text-green-50' }}">🏪
                বাজার</a>
            <a href="{{ route('members.index') }}"
                class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('members.*') ? 'active text-green-400 border' : 'text-textdim hover:text-green-50' }}">👥
                সদস্য</a>
            <a href="{{ route('prices.index') }}"
                class="nav-item flex items-center gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('prices.*') ? 'active text-green-400 border' : 'text-textdim hover:text-green-50' }}">💰
                দাম রেকর্ড</a>
        </nav>

        <div class="p-3" style="border-top:1px solid #2a3d2f">
            <div class="flex items-center gap-2.5 p-2.5 rounded-xl" style="background:#1e2d22">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold text-black"
                    style="background:linear-gradient(135deg,#4ade80,#16a34a)">{{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold truncate">{{ auth()->user()->name }}</div>
                    <div class="text-xs" style="color:#5a7560">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit"
                        class="text-xs p-1 rounded" style="color:#5a7560">⏻</button></form>
            </div>
        </div>
    </aside>

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-40 hidden" onclick="closeSidebar()"></div>

    <div class="lg:ml-60 min-h-screen flex flex-col">
        <header class="sticky top-0 z-30 flex items-center gap-4 px-6 py-3.5"
            style="background:rgba(15,26,18,.85);backdrop-filter:blur(20px);border-bottom:1px solid #2a3d2f">
            <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg"
                style="background:#1e2d22;border:1px solid #2a3d2f">☰</button>
            <h1 class="font-syne font-bold text-base flex-1">@yield('page-title', 'Dashboard')</h1>
            @if(session('success'))
            <div class="hidden" id="flash-msg" data-msg="{{ session('success') }}"></div> @endif
            @yield('topbar-actions')
            <div class="flex items-center gap-2 text-xs px-3 py-1.5 rounded-lg"
                style="background:#1e2d22;color:#5a7560">
                <span>📅</span> <span>{{ now()->setTimezone('Asia/Dhaka')->format('d M Y') }}</span>
            </div>
        </header>

        <main class="flex-1 p-6">@yield('content')</main>
    </div>

    <div id="toast-wrap" class="fixed bottom-6 right-6 z-[9999] flex flex-col gap-2 pointer-events-none"></div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
            document.getElementById('sidebar-overlay').classList.toggle('hidden');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebar-overlay').classList.add('hidden');
        }
        function toast(msg, type = 'success') {
            const wrap = document.getElementById('toast-wrap');
            const t = document.createElement('div');
            const color = type === 'success' ? '#4ade80' : '#f87171';
            t.style.cssText = `background:#1e2d22; border:1px solid ${color}44; border-radius:12px; padding:12px 16px; display:flex; align-items:center; gap:10px; box-shadow:0 8px 30px rgba(0,0,0,.4); font-size:13px; color:#e8f5ea; min-width:240px; pointer-events:auto; animation: toastIn .3s ease;`;
            t.innerHTML = `<span>${type === 'success' ? '✅' : '❌'}</span> ${msg}`;
            wrap.appendChild(t);
            setTimeout(() => t.remove(), 3500);
        }
        document.addEventListener('DOMContentLoaded', () => {
            const flash = document.getElementById('flash-msg');
            if (flash) toast(flash.dataset.msg, 'success');
            if (window.Chart) { Chart.defaults.color = '#9ab09e'; Chart.defaults.borderColor = '#2a3d2f'; Chart.defaults.font.family = 'DM Sans'; }
        });
    </script>

    @stack('scripts')
</body>

</html>
