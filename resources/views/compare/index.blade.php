@extends('layouts.app')

@section('title', 'দাম তুলনা')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&family=Hind+Siliguri:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg0: #050a06;
            --bg1: #0c1410;
            --bg2: #121d16;
            --b0: rgba(16, 185, 129, 0.08);
            --b1: rgba(16, 185, 129, 0.2);
            --tx0: #f4f4f5;
            --tx1: #71717a;
            --tx2: #3f624d;
            --g0: #10b981;
            --r-: #ef4444;
            --fn: 'Bricolage Grotesque', sans-serif;
            --fm: 'JetBrains Mono', monospace;
            --fb: 'Hind Siliguri', sans-serif;
        }

        .ot-wrap {
            background: var(--bg0);
            min-height: 100vh;
            padding: 40px 24px;
            position: relative;
            overflow-x: hidden;
            font-family: var(--fb);
            color: var(--tx0);
        }

        /* Grid Texture Overlay */
        .ot-wrap::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(16, 185, 129, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(16, 185, 129, 0.02) 1px, transparent 1px);
            background-size: 52px 52px;
            mask-image: radial-gradient(circle at center, black, transparent 80%);
        }

        .ot-inner {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
        }

        .ot-card {
            background: var(--bg1);
            border: 1px solid var(--b0);
            border-radius: 32px;
            padding: 24px;
            backdrop-filter: blur(12px);
        }

        .stat-val {
            font-family: var(--fm);
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.05em;
        }

        .stat-label {
            font-family: var(--fm);
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--tx1);
        }

        .ot-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .ot-table th {
            padding: 12px 20px;
            text-align: left;
            font-family: var(--fm);
            font-size: 10px;
            color: var(--tx2);
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .ot-table td {
            background: var(--bg2);
            padding: 20px;
            border-top: 1px solid var(--b0);
            border-bottom: 1px solid var(--b0);
        }

        .ot-table td:first-child {
            border-left: 1px solid var(--b0);
            border-top-left-radius: 20px;
            border-bottom-left-radius: 20px;
        }

        .ot-table td:last-child {
            border-right: 1px solid var(--b0);
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
        }

        .row-highlight-buy td {
            border-color: rgba(16, 185, 129, 0.2);
            background: rgba(16, 185, 129, 0.04);
        }

        .row-highlight-sell td {
            border-color: rgba(239, 68, 68, 0.2);
            background: rgba(239, 68, 68, 0.04);
        }

        .btn-call {
            background: #18181b;
            border: 1px solid var(--b1);
            color: var(--g0);
            padding: 10px 18px;
            border-radius: 14px;
            font-size: 12px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-call:hover {
            background: var(--g0);
            color: var(--bg0);
            transform: translateY(-2px);
        }

        .ot-sel {
            background: #040805;
            border: 1px solid var(--b0);
            color: var(--tx0);
            padding: 14px 20px;
            border-radius: 16px;
            outline: none;
            appearance: none;
        }

        @media (max-width: 768px) {
            .ot-wrap {
                padding: 20px 12px;
            }

            .ot-card {
                border-radius: 20px;
                padding: 16px;
            }

            .ot-inner > .mb-12 h1 {
                font-size: 2rem;
                line-height: 1.15;
            }

            .ot-table {
                min-width: 760px;
            }

            .ot-table th {
                padding: 10px 14px;
            }

            .ot-table td {
                padding: 14px;
            }

            .btn-call {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ot-wrap">
        <div class="ot-inner">
            <div class="mb-12">
                <h1 class="text-5xl font-black tracking-tighter text-white font-['Bricolage_Grotesque'] mb-3">দাম তুলনা</h1>
                <p class="text-zinc-500 font-medium">সব বাজারের দামের তুলনামূলক বিশ্লেষণ ও লাইভ ট্র্যাকিং সিস্টেম।</p>
            </div>

            {{-- Top Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="ot-card" style="border-top: 2px solid var(--g0)">
                    <div class="stat-label mb-2">সর্বনিম্ন দাম (Buy)</div>
                    <div class="stat-val text-emerald-400">৳{{ number_format($minPrice, 2) }}</div>
                    <p class="text-[10px] uppercase font-bold text-emerald-900 mt-2 tracking-widest">সেরা ক্রয় এলাকা</p>
                </div>
                <div class="ot-card" style="border-top: 2px solid var(--tx1)">
                    <div class="stat-label mb-2">গড় বাজার দর</div>
                    <div class="stat-val text-zinc-300">৳{{ number_format($avgPrice, 2) }}</div>
                    <p class="text-[10px] uppercase font-bold text-zinc-800 mt-2 tracking-widest">সাধারণ গড় মূল্য</p>
                </div>
                <div class="ot-card" style="border-top: 2px solid var(--r-)">
                    <div class="stat-label mb-2">সর্বোচ্চ দাম (Sell)</div>
                    <div class="stat-val text-rose-500">৳{{ number_format($maxPrice, 2) }}</div>
                    <p class="text-[10px] uppercase font-bold text-rose-900 mt-2 tracking-widest">সেরা বিক্রয় এলাকা</p>
                </div>
            </div>

            {{-- Filter Bar --}}
            <div class="ot-card mb-8">
                <form action="{{ route('compare.index') }}" method="GET" class="flex flex-wrap items-center gap-6">
                    <div class="flex-1 min-w-[200px]">
                        <label class="stat-label block mb-3">বিভাগ ফিল্টার</label>
                        <div class="relative">
                            <select name="division" class="ot-sel w-full">
                                <option value="">সব বিভাগ</option>
                                @foreach($divisions as $div)
                                    <option value="{{ $div }}" {{ request('division') == $div ? 'selected' : '' }}>{{ $div }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit"
                        class="bg-emerald-500 text-black px-10 py-4 rounded-2xl font-black text-sm hover:brightness-110 transition-all self-end">
                        ফিল্টার আপডেট
                    </button>
                </form>
            </div>

            {{-- Comparison Table --}}
            <div class="overflow-x-auto">
                <table class="ot-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>বাজার ও অবস্থান</th>
                            <th>মূল্য / কেজি</th>
                            <th>সাশ্রয় (Diff)</th>
                            <th>নিযুক্ত সদস্য</th>
                            <th>যোগাযোগ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($markets as $index => $market)
                            @php
                                $priceDiff = $maxPrice - $market->latest_price_value;
                                $isCheapest = $market->latest_price_value == $minPrice;
                                $isMostExpensive = $market->latest_price_value == $maxPrice;
                            @endphp
                            <tr
                                class="{{ $isCheapest ? 'row-highlight-buy' : ($isMostExpensive ? 'row-highlight-sell' : '') }}">
                                <td><span class="font-data text-zinc-700 font-bold">{{ sprintf('%02d', $index + 1) }}</span>
                                </td>
                                <td>
                                    <div class="font-bold text-white text-lg">{{ $market->name }}</div>
                                    <div class="text-[10px] font-data uppercase text-zinc-500">{{ $market->division }}</div>
                                </td>
                                <td>
                                    <div
                                        class="text-2xl font-black font-data {{ $isCheapest ? 'text-emerald-400' : ($isMostExpensive ? 'text-rose-500' : 'text-white') }}">
                                        ৳{{ number_format($market->latest_price_value, 2) }}
                                    </div>
                                </td>
                                <td>
                                    @if($priceDiff > 0)
                                        <div
                                            class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 font-data text-[11px] font-bold">
                                            +৳{{ number_format($priceDiff, 2) }}
                                        </div>
                                    @else
                                        <span class="text-zinc-800">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if($market->member)
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-zinc-900 border border-white/5 flex items-center justify-center font-bold text-emerald-500">
                                                {{ mb_substr($market->member->name, 0, 1) }}
                                            </div>
                                            <div class="text-sm font-semibold text-zinc-300">{{ $market->member->name }}</div>
                                        </div>
                                    @else
                                        <span class="text-[10px] uppercase font-bold text-zinc-800">No Member</span>
                                    @endif
                                </td>
                                <td>
                                    @if($market->member)
                                        <a href="{{ $market->member->tel_link }}" class="btn-call">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="3">
                                                <path
                                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                </path>
                                            </svg>
                                            Call Member
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-32">
                                    <div class="text-6xl mb-6">📉</div>
                                    <div class="text-zinc-600 font-bold uppercase tracking-widest text-xs">No Comparison Data
                                        Available</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
