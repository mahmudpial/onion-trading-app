<!DOCTYPE html>
<html lang="bn" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'পেঁয়াজ ট্রেডিং') - Onion Trade Pro</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('brand/oniontrade-icon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('brand/oniontrade-icon-180.png') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" x-init></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;600;800&family=JetBrains+Mono:wght@400;700&family=Hind+Siliguri:wght@400;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --emerald-glow: rgba(16, 185, 129, 0.15);
        }

        body {
            font-family: 'Hind Siliguri', sans-serif;
            background-color: #09090b;
        }

        .font-data {
            font-family: 'JetBrains Mono', monospace;
        }

        .font-display {
            font-family: 'Bricolage Grotesque', sans-serif;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .app-footer {
            position: relative;
            margin-top: 3rem;
            border-top: 1px solid rgba(16, 185, 129, 0.12);
            background: linear-gradient(180deg, rgba(12, 20, 16, 0.2) 0%, rgba(5, 10, 6, 0.75) 100%);
            overflow: hidden;
        }

        .app-footer::before {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(16, 185, 129, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(16, 185, 129, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(circle at center, black, transparent 85%);
        }

        .app-footer-inner {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr 1fr;
            gap: 1.5rem;
            padding: 1.75rem 0 1.25rem;
        }

        .footer-brand {
            display: flex;
            gap: 0.9rem;
            align-items: flex-start;
        }

        .footer-brand-mark {
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.7rem;
            border: 1px solid rgba(16, 185, 129, 0.25);
            background: rgba(16, 185, 129, 0.08);
            color: #34d399;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .footer-brand-mark img {
            width: 1.45rem;
            height: 1.45rem;
            border-radius: 0.35rem;
        }

        .footer-brand-title {
            font-family: 'Bricolage Grotesque', sans-serif;
            font-size: 0.98rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            color: #fafafa;
            text-transform: uppercase;
        }

        .footer-brand-meta {
            margin-top: 0.35rem;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.62rem;
            letter-spacing: 0.2em;
            color: #52525b;
            text-transform: uppercase;
        }

        .footer-brand-desc {
            margin-top: 0.45rem;
            font-size: 0.76rem;
            color: #a1a1aa;
            max-width: 38ch;
            line-height: 1.62;
        }

        .footer-title {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.62rem;
            letter-spacing: 0.2em;
            color: #71717a;
            text-transform: uppercase;
            margin-bottom: 0.7rem;
        }

        .footer-nav {
            display: grid;
            grid-template-columns: 1fr 1fr;
            column-gap: 0.75rem;
            row-gap: 0.65rem;
            align-content: start;
        }

        .footer-link {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.5rem 0.72rem;
            border-radius: 0.65rem;
            border: 1px solid rgba(255, 255, 255, 0.04);
            background: rgba(255, 255, 255, 0.01);
            font-size: 0.71rem;
            font-weight: 700;
            letter-spacing: 0.01em;
            color: #b4b4bd;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .footer-quick {
            display: flex;
            flex-direction: column;
            gap: 0.9rem;
        }

        .footer-link:hover {
            color: #f4f4f5;
            border-color: rgba(16, 185, 129, 0.18);
            background: rgba(16, 185, 129, 0.06);
            transform: translateY(-1px);
        }

        .footer-link-dot {
            width: 0.35rem;
            height: 0.35rem;
            border-radius: 999px;
            background: #10b981;
            opacity: 0.8;
            flex-shrink: 0;
        }

        .footer-insight {
            border: 1px solid rgba(16, 185, 129, 0.12);
            border-radius: 0.95rem;
            background: rgba(16, 185, 129, 0.04);
            padding: 0.8rem;
        }

        .footer-insight-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.6rem;
            padding: 0.35rem 0;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.62rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
        }

        .footer-insight-label {
            color: #71717a;
        }

        .footer-insight-val {
            color: #d4d4d8;
            font-weight: 700;
        }

        .footer-bottom {
            position: relative;
            z-index: 1;
            border-top: 1px solid rgba(16, 185, 129, 0.09);
            padding: 0.85rem 0 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .footer-bottom-meta {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.58rem;
            letter-spacing: 0.15em;
            color: #52525b;
            text-transform: uppercase;
        }

        .footer-right {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 0.8rem;
            text-align: left;
        }

        .footer-system-badges {
            display: flex;
            justify-content: flex-end;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .footer-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.65rem;
            border-radius: 999px;
            border: 1px solid rgba(16, 185, 129, 0.15);
            background: rgba(16, 185, 129, 0.06);
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.58rem;
            letter-spacing: 0.09em;
            color: #a1a1aa;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .footer-copyright {
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.62rem;
            letter-spacing: 0.14em;
            color: #71717a;
            text-transform: uppercase;
        }

        @media (max-width: 768px) {
            .brand-text {
                font-size: 0.9rem;
                letter-spacing: -0.01em;
            }

            .topbar-actions {
                width: 100%;
                flex-wrap: wrap;
            }

            .topbar-actions > * {
                flex: 1 1 auto;
            }

            .app-footer {
                margin-top: 2rem;
            }

            .app-footer-inner {
                grid-template-columns: 1fr;
                gap: 1rem;
                padding: 1.25rem 0;
            }

            .footer-nav {
                grid-template-columns: 1fr;
            }

            .footer-system-badges {
                justify-content: flex-start;
            }

            .footer-bottom {
                padding-top: 0.75rem;
            }
        }
    </style>
    @stack('styles')
</head>

<body class="text-zinc-100 min-h-screen selection:bg-emerald-500/30 selection:text-emerald-200">
    @auth
        <nav class="sticky top-0 z-50 bg-zinc-950/80 backdrop-blur-xl border-b border-zinc-800/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <div class="flex justify-between h-16">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-zinc-950 transition-all duration-300">
                                <img src="{{ asset('brand/oniontrade-icon-32.png') }}" alt="OnionTrade Icon" class="w-5 h-5 rounded">
                            </div>
                            <span class="brand-text font-display font-extrabold text-lg tracking-tight text-white uppercase">ONION
                                TRADE <span
                                    class="text-emerald-500 text-xs font-black tracking-widest ml-1">PRO</span></span>
                        </a>
                    </div>

                    <div class="flex items-center gap-4">
                        <div class="hidden sm:flex flex-col items-end">
                            <span
                                class="text-[10px] font-data font-bold text-zinc-500 uppercase tracking-tighter">Authorized
                                User</span>
                            <span class="text-sm font-bold text-zinc-200 leading-none">{{ auth()->user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="ml-2">
                            @csrf
                            <button type="submit"
                                class="p-2 rounded-xl bg-zinc-900 border border-zinc-800 text-rose-500 hover:bg-rose-500/10 hover:border-rose-500/30 transition-all shadow-sm group"
                                title="প্রস্থান">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                    <polyline points="16 17 21 12 16 7" />
                                    <line x1="21" y1="12" x2="9" y2="12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="border-t border-zinc-900 bg-zinc-950/50">
                <div class="max-w-7xl mx-auto px-4">
                    <div
                        class="flex items-center space-x-1 overflow-x-auto py-2 hide-scrollbar font-data text-[11px] font-bold uppercase tracking-wider">
                        @php
                            $links = [
                                ['route' => 'dashboard', 'icon' => '📊', 'label' => 'ড্যাশবোর্ড'],
                                ['route' => 'markets.index', 'icon' => '🏪', 'label' => 'বাজার'],
                                ['route' => 'members.index', 'icon' => '👥', 'label' => 'সদস্য'],
                                ['route' => 'prices.index', 'icon' => '💰', 'label' => 'দাম রেকর্ড'],
                                ['route' => 'compare.index', 'icon' => '⚖️', 'label' => 'তুলনা'],
                                ['route' => 'analytics.index', 'icon' => '📈', 'label' => 'বিশ্লেষণ'],
                            ];
                        @endphp

                        @foreach($links as $link)
                            <a href="{{ route($link['route']) }}"
                                class="flex items-center gap-2 px-4 py-2 rounded-xl transition-all duration-200 whitespace-nowrap {{ request()->routeIs(str_replace('.index', '*', $link['route'])) ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 shadow-[0_0_15px_rgba(16,185,129,0.05)]' : 'text-zinc-500 hover:text-zinc-200 hover:bg-zinc-900' }}">
                                <span class="text-sm grayscale group-hover:grayscale-0 opacity-70">{{ $link['icon'] }}</span>
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{-- Header with Title and Dynamic Actions --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-black text-white font-display tracking-tight uppercase">
                        @yield('page-title', 'Dashboard')</h1>
                    <p class="text-[10px] font-data font-bold text-zinc-600 uppercase tracking-[0.3em] mt-1">System Node:
                        PialMahmud_Core
                    </p>
                </div>

                {{-- This is where the buttons (like "Add Member") will appear --}}
                <div class="topbar-actions flex items-center gap-3">
                    @yield('topbar-actions')
                </div>
            </div>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div
                    class="mb-8 p-4 rounded-2xl bg-emerald-500/5 border border-emerald-500/20 flex items-center justify-between group animate-in fade-in slide-in-from-top-4 duration-500">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        <span class="text-sm font-bold text-emerald-200">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-zinc-600 hover:text-white transition-colors"><svg
                            width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg></button>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="app-footer">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="app-footer-inner">
                    <div class="footer-brand">
                        <div class="footer-brand-mark">
                            <img src="{{ asset('brand/oniontrade-icon-32.png') }}" alt="OnionTrade Icon">
                        </div>
                        <div>
                            <div class="footer-brand-title">Onion Trade Professional</div>
                            <div class="footer-brand-meta">System Node: PialMahmud_Core</div>
                            <p class="footer-brand-desc">Real-time onion market intelligence for trusted pricing, faster decisions, and disciplined trading operations.</p>
                        </div>
                    </div>

                    <div class="footer-quick">
                        <div class="footer-title">Quick Access</div>
                        <div class="footer-nav">
                            <a href="{{ route('dashboard') }}" class="footer-link"><span class="footer-link-dot"></span>Dashboard</a>
                            <a href="{{ route('prices.index') }}" class="footer-link"><span class="footer-link-dot"></span>Price Ledger</a>
                            <a href="{{ route('compare.index') }}" class="footer-link"><span class="footer-link-dot"></span>Compare</a>
                            <a href="{{ route('analytics.index') }}" class="footer-link"><span class="footer-link-dot"></span>Analytics</a>
                        </div>
                    </div>

                    <div class="footer-right">
                        <div class="footer-title">System Insights</div>
                        <div class="footer-insight">
                            <div class="footer-insight-row">
                                <span class="footer-insight-label">Node</span>
                                <span class="footer-insight-val">PialMahmud_Core</span>
                            </div>
                            <div class="footer-insight-row">
                                <span class="footer-insight-label">Region</span>
                                <span class="footer-insight-val">Asia/Dhaka</span>
                            </div>
                            <div class="footer-insight-row">
                                <span class="footer-insight-label">Release</span>
                                <span class="footer-insight-val">v2.0.4-stable</span>
                            </div>
                        </div>
                        <div class="footer-system-badges">
                            <span class="footer-badge">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Node Online
                            </span>
                            <span class="footer-badge">DB Latency: 24ms</span>
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="footer-copyright">
                        &copy; {{ date('Y') }} Onion Trade Professional. All rights reserved.
                    </div>
                    <div class="footer-bottom-meta">
                        Secure Market Intelligence Platform
                    </div>
                </div>
            </div>
        </footer>
    @else
        <div class="min-h-screen bg-zinc-950">
            @yield('guest-content')
        </div>
    @endauth

    @stack('scripts')
</body>

</html>
