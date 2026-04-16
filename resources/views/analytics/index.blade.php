@extends('layouts.app')

@section('title', 'Market Intelligence')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;600;800&family=JetBrains+Mono:wght@400;700&family=Hind+Siliguri:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg: #050a06;
            --card: rgba(12, 20, 16, 0.7);
            --accent: #10b981;
            --border: rgba(16, 185, 129, 0.1);
            --zinc-500: #71717a;
            --zinc-900: #18181b;
        }

        .dashboard-container {
            background: var(--bg);
            min-height: 100vh;
            padding: 2rem;
            font-family: 'Hind Siliguri', sans-serif;
            color: #fff;
        }

        /* Floating Action Bar */
        .action-header {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--border);
            border-radius: 100px;
            padding: 0.75rem 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(20px);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .bento-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 28px;
            padding: 1.5rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .bento-card:hover {
            border-color: var(--accent);
        }

        .stat-label {
            font-family: 'JetBrains Mono';
            font-size: 10px;
            color: var(--zinc-500);
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .font-data {
            font-family: 'JetBrains Mono', monospace;
        }

        /* Prediction Glow */
        .forecast-box {
            background: linear-gradient(145deg, rgba(16, 185, 129, 0.1), transparent);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        @media (max-width: 768px) {
            .dashboard-container {
                padding: 1rem;
            }

            .action-header {
                border-radius: 24px;
                flex-direction: column;
                align-items: stretch;
                gap: 0.75rem;
                padding: 1rem;
            }

            .action-header form {
                width: 100%;
                flex-wrap: wrap;
                gap: 0.75rem;
            }

            .action-header form > * {
                flex: 1 1 100%;
            }

            .bento-card {
                border-radius: 20px;
                padding: 1rem;
            }

            .forecast-box .text-5xl {
                font-size: 2.25rem;
                line-height: 1.15;
            }
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-container">

        <div class="action-header">
            <div class="flex items-center gap-4">
                <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse"></div>
                <h1 class="text-lg font-bold font-['Bricolage_Grotesque'] tracking-tight">Intelligence Dashboard</h1>
            </div>

            <form action="{{ route('analytics.index') }}" method="GET" class="flex items-center gap-4">
                <select name="market_id"
                    class="bg-transparent text-sm border-none focus:ring-0 text-zinc-400 cursor-pointer">
                    <option value="">Global Markets</option>
                    @foreach($markets as $market)
                        <option value="{{ $market->id }}" @selected($selectedMarketId == $market->id)>
                            {{ $market->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit"
                    class="bg-white text-black px-5 py-2 rounded-full font-bold text-xs hover:scale-105 transition-transform">
                    Refresh Data
                </button>
            </form>
        </div>

        <div class="grid grid-cols-12 gap-6">

            <div class="col-span-12 lg:col-span-8 bento-card min-h-[450px]">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <span class="stat-label">Market Velocity</span>
                        <h2 class="text-2xl font-extrabold font-['Bricolage_Grotesque']">মূল্য বিশ্লেষণ ও প্রবণতা</h2>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-1 bg-emerald-500"></div><span
                                class="text-[9px] text-zinc-500 font-bold uppercase">Daily</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-[1px] bg-zinc-600 border-dashed border-zinc-600"></div><span
                                class="text-[9px] text-zinc-500 font-bold uppercase">7D MA</span>
                        </div>
                    </div>
                </div>
                <div class="h-[320px]">
                    <canvas id="intelligenceChart"></canvas>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-4 flex flex-col gap-6">

                <div class="bento-card forecast-box flex-1">
                    <span class="stat-label">Next Week Forecast</span>
                    <div class="mt-4">
                        <span
                            class="text-5xl font-black font-data text-emerald-400">৳{{ number_format($predictedPrice, 0) }}</span>
                        <p class="text-xs text-zinc-500 mt-2">AI-driven linear regression based on last 30 days.</p>
                    </div>
                    <div class="mt-8 pt-6 border-t border-white/5 flex justify-between">
                        <div>
                            <span class="stat-label">Trend</span>
                            <div
                                class="font-bold {{ $predictedPrice > $currentPrice ? 'text-emerald-500' : 'text-rose-500' }}">
                                {{ $predictedPrice > $currentPrice ? '↑ Rising' : '↓ Falling' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="stat-label">Confidence</span>
                            <div class="font-bold text-zinc-400">84%</div>
                        </div>
                    </div>
                </div>

                <div class="bento-card flex-1">
                    <span class="stat-label">Market Volatility (σ)</span>
                    <div class="mt-6 space-y-4">
                        @foreach($marketPrices->take(3) as $mp)
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-bold">{{ $mp['name'] }}</span>
                                {{-- Use 'status_class' and 'status' directly from the array --}}
                                <span class="text-[9px] font-black uppercase px-2 py-1 rounded-md {{ $mp['status_class'] }}">
                                    {{ $mp['status'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-span-12 bento-card">
                <span class="stat-label mb-6 block">Market-wise Live Comparison</span>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($marketPrices as $mp)
                        <div class="p-4 rounded-2xl bg-zinc-900/50 border border-white/5 hover:bg-zinc-900 transition-colors">
                            <div class="flex justify-between items-start mb-4">
                                <span class="font-bold text-sm">{{ $mp['name'] }}</span>
                                <span class="font-data text-xs text-zinc-500">৳{{ number_format($mp['price'], 0) }}</span>
                            </div>
                            <div class="w-full h-1 bg-zinc-800 rounded-full overflow-hidden">
                                @php $prog = ($mp['price'] / $marketPrices->max('price')) * 100; @endphp
                                <div class="h-full bg-emerald-500" style="width: {{ $prog }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('intelligenceChart').getContext('2d');

        const rawData = @json(collect($trend)->pluck('avg_price'));
        const labels = @json(collect($trend)->pluck('label'));

        // 7-Day Moving Average Algorithm
        const getMA = (data, p) => data.map((v, i) => {
            if (i < p - 1) return null;
            return data.slice(i - p + 1, i + 1).reduce((a, b) => a + b, 0) / p;
        });

        const ma7 = getMA(rawData, 7);

        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(16, 185, 129, 0.15)');
        gradient.addColorStop(1, 'rgba(16, 185, 129, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: '7D Moving Average',
                        data: ma7,
                        borderColor: 'rgba(255,255,255,0.2)',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        pointRadius: 0,
                        tension: 0.4
                    },
                    {
                        label: 'Daily Avg',
                        data: rawData,
                        borderColor: '#10b981',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: 'rgba(255,255,255,0.1)'
                    }
                ]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { color: '#71717a', font: { family: 'JetBrains Mono' } } },
                    x: { grid: { display: false }, ticks: { color: '#71717a', font: { family: 'JetBrains Mono' } } }
                }
            }
        });
    </script>
@endpush
