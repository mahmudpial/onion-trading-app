@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('topbar-actions')
    <a href="{{ route('prices.create') }}" class="ot-btn-primary">
        <svg width="13" height="13" viewBox="0 0 13 13" fill="none">
            <path d="M6.5 1v11M1 6.5h11" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" />
        </svg>
        <span>দাম যোগ করুন</span>
    </a>
@endsection

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;600;800&family=JetBrains+Mono:wght@400;700&family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg0: #050a06;
            --bg1: #0c1410;
            --bg2: #121d16;
            --b0: rgba(16, 185, 129, 0.08);
            --b1: rgba(16, 185, 129, 0.2);
            --tx0: #f4f4f5;
            --tx1: #71717a;
            --g0: #10b981;
            --fn: 'Bricolage Grotesque', sans-serif;
            --fm: 'JetBrains Mono', monospace;
        }

        /* --- Ticker Animation Logic --- */
        .ticker-container {
            width: 100%;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .ticker-track {
            display: flex;
            width: max-content;
            animation: ticker-scroll 40s linear infinite;
            gap: 24px;
        }

        .ticker-container:hover .ticker-track {
            animation-play-state: paused;
        }

        @keyframes ticker-scroll {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        @keyframes alert-pulse {
            0% { border-color: rgba(225, 29, 72, 0.2); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.2); }
            50% { border-color: rgba(225, 29, 72, 0.6); box-shadow: 0 0 10px 2px rgba(225, 29, 72, 0.2); }
            100% { border-color: rgba(225, 29, 72, 0.2); box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.2); }
        }

        .price-alert {
            animation: alert-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            border: 1px solid #e11d48 !important;
        }

        .breaking-badge {
            background: #e11d48;
            color: white;
            padding: 1px 5px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 900;
            text-transform: uppercase;
            margin-bottom: 2px;
            display: inline-block;
        }

        .ot-wrap {
            background: var(--bg0);
            min-height: 100vh;
            padding: 32px 24px 80px;
            position: relative;
            overflow-x: hidden;
            font-family: 'Hind Siliguri', sans-serif;
            color: var(--tx0);
        }

        .ot-wrap::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(16, 185, 129, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(16, 185, 129, 0.03) 1px, transparent 1px);
            background-size: 52px 52px;
            mask-image: radial-gradient(circle at center, black, transparent 80%);
        }

        .ot-card {
            background: var(--bg1);
            border: 1px solid var(--b0);
            border-radius: 28px;
            padding: 24px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(12px);
            position: relative;
        }

        .ot-card:hover {
            border-color: var(--b1);
            transform: translateY(-4px);
            background: var(--bg2);
        }

        .ot-label {
            font-family: var(--fm);
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--tx1);
        }

        .ot-value {
            font-family: var(--fn);
            font-size: 32px;
            font-weight: 800;
            color: var(--tx0);
            letter-spacing: -0.03em;
        }

        .ot-btn-primary {
            background: linear-gradient(135deg, var(--g0), #059669);
            color: #050a06;
            padding: 10px 20px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.4);
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .ot-wrap {
                padding: 16px 12px 48px;
            }

            .ot-card {
                border-radius: 20px;
                padding: 16px;
            }

            .ticker-track {
                gap: 12px;
            }

            .ot-value {
                font-size: 2rem;
                line-height: 1.15;
            }

            .ot-btn-primary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ot-wrap">
        <div class="max-w-7xl mx-auto relative z-10">

            <div class="mb-12 text-center md:text-left">
                @php
                    $hour = now()->timezone('Asia/Dhaka')->hour;
                    if ($hour >= 5 && $hour < 12) {
                        $greeting = 'শুভ সকাল';
                    } elseif ($hour >= 12 && $hour < 16) {
                        $greeting = 'শুভ দুপুর';
                    } elseif ($hour >= 16 && $hour < 18) {
                        $greeting = 'শুভ বিকাল';
                    } elseif ($hour >= 18 && $hour < 22) {
                        $greeting = 'শুভ সন্ধ্যা';
                    } else {
                        $greeting = 'শুভ রাত্রি';
                    }
                @endphp
                <h1 class="text-4xl font-extrabold text-white tracking-tight font-['Bricolage_Grotesque']">
                    {{ $greeting }}, <span class="text-emerald-500">{{ auth()->user()->name }}</span>
                </h1>
                <p class="text-zinc-500 mt-2 font-medium italic">আজকের পেঁয়াজ বাজারের সারসংক্ষেপ এবং বিশ্লেষণ।</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                {{-- 🚀 LIVE TICKER SECTION (এটিই আপনি খুঁজছেন) --}}
                <div class="md:col-span-4 mb-2">
                    <div class="ot-card !p-0 overflow-hidden border-emerald-500/10 flex items-center h-16">
                        <div class="flex-shrink-0 z-20 bg-[var(--bg1)] px-6 h-full flex items-center border-r border-white/10 text-[10px] font-data font-bold text-emerald-500 uppercase tracking-widest shadow-[10px_0_15px_-5px_rgba(0,0,0,0.5)]">
                            LIVE TICKER
                        </div>
                        
                        <div class="ticker-container">
                            <div class="ticker-track">
                                @foreach([1, 2] as $iteration)
                                    @foreach($marketList as $market)
                                        @php 
                                            $latestPrice = $market->prices->first();
                                            $volatility = app(\App\Services\MarketService::class)->getMarketVolatility($market->id);
                                            $isAlert = abs($volatility['change']) >= 5; 
                                        @endphp
                                        <a href="{{ route('markets.show', $market->id) }}" 
                                           class="inline-flex items-center gap-4 px-4 py-2 rounded-2xl bg-zinc-950/50 border {{ $isAlert ? 'price-alert' : 'border-white/5' }} hover:border-emerald-500/40 transition-all group/item whitespace-nowrap">
                                            <div class="flex flex-col">
                                                @if($isAlert)
                                                    <span class="breaking-badge">Alert</span>
                                                @endif
                                                <span class="text-[11px] font-bold text-zinc-400 group-hover/item:text-white">{{ $market->name }}</span>
                                                @if($volatility['change'] != 0)
                                                    <span class="text-[9px] font-data font-bold {{ $volatility['direction'] == 'up' ? 'text-rose-500' : 'text-emerald-500' }}">
                                                        {{ $volatility['direction'] == 'up' ? '↑' : '↓' }} {{ abs($volatility['change']) }}%
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="px-2 py-1 rounded-lg {{ $isAlert ? 'bg-rose-500/10 text-rose-400 border-rose-500/20' : 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20' }} text-[10px] font-data font-bold border">
                                                ৳{{ number_format($latestPrice?->price ?? 0) }}
                                            </div>
                                        </a>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main Stats --}}
                <div class="md:col-span-2 ot-card flex flex-col justify-between min-h-[220px]">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-emerald-500/10 blur-[80px] -mr-16 -mt-16 pointer-events-none"></div>
                    <div>
                        <div class="ot-label">গড় বাজার দর</div>
                        <div class="ot-value mt-2 text-6xl">৳{{ number_format($avgPrice, 2) }}</div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2 py-0.5 rounded-lg bg-emerald-500/10 text-emerald-400 font-data text-[10px] font-bold uppercase">Live Update</span>
                        <span class="text-[10px] text-zinc-600 font-bold uppercase tracking-widest">সকল বিভাগ মিলিয়ে</span>
                    </div>
                </div>

                {{-- Trend Chart --}}
                <div class="md:col-span-2 ot-card min-h-[220px]">
                    <div class="flex items-center justify-between mb-4">
                        <div class="ot-label text-emerald-500/80">৭ দিনের বাজার ট্রেন্ড</div>
                    </div>
                    <div class="h-[140px] w-full relative">
                        <canvas id="priceTrendChart"></canvas>
                    </div>
                </div>

                {{-- Small Stats --}}
                <div class="ot-card">
                    <div class="ot-label mb-3">বাজারের সংখ্যা</div>
                    <div class="ot-value">{{ $marketsCount }}</div>
                </div>

                <div class="ot-card">
                    <div class="ot-label mb-3">আজকের আপডেট</div>
                    <div class="ot-value">{{ $todayRecordsCount }}</div>
                </div>

                {{-- 📍 MARKET LIST SECTION --}}
                <div class="md:col-span-4 mt-6">
                    <div class="flex items-center justify-between mb-8">
                        <h2 class="text-2xl font-extrabold text-white font-['Bricolage_Grotesque'] tracking-tight">বাজারের অবস্থা</h2>
                        <a href="{{ route('markets.index') }}" class="ot-label hover:text-emerald-500 transition-colors">সব দেখুন →</a>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($markets as $market)
                            <a href="{{ route('markets.show', $market->id) }}" class="ot-card group !no-underline">
                                <div class="flex justify-between items-start mb-8">
                                    <div>
                                        <h3 class="text-xl font-bold text-white group-hover:text-emerald-400 transition-colors">{{ $market->name }}</h3>
                                        <p class="text-xs text-zinc-500 font-medium">{{ $market->division }} বিভাগ</p>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-data font-bold text-emerald-500 text-xl">৳{{ number_format($market->latest_price_value, 2) }}</div>
                                        <div class="text-[9px] text-zinc-600 font-bold uppercase">প্রতি কেজি</div>
                                    </div>
                                </div>

                                @if($market->member)
                                    <div class="flex items-center justify-between p-3 rounded-2xl bg-zinc-950/40 border border-white/5 hover:bg-zinc-900 transition-all">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-xs font-black text-emerald-500">
                                                {{ mb_strtoupper(mb_substr($market->member->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-xs font-bold text-zinc-200">{{ $market->member->name }}</div>
                                                <div class="text-[10px] text-zinc-500">{{ $market->member->phone }}</div>
                                            </div>
                                        </div>
                                        <div class="text-[9px] font-bold text-zinc-700 uppercase group-hover:text-emerald-500">View details →</div>
                                    </div>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('priceTrendChart').getContext('2d');
            const trendData = @json($priceTrend); 
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: trendData.map(item => item.label),
                    datasets: [{
                        data: trendData.map(item => item.avg_price),
                        borderColor: '#10b981',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#71717a' } },
                        y: { grid: { color: 'rgba(113, 113, 122, 0.05)' }, ticks: { color: '#71717a' } }
                    }
                }
            });
        });
    </script>
@endpush
