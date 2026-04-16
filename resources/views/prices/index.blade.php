@extends('layouts.app')

@section('title', 'দাম রেকর্ড')
@section('page-title', '💰 দাম রেকর্ড')

@section('topbar-actions')
    <a href="{{ route('prices.create') }}" class="ot-btn-primary">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        <span>নতুন দাম</span>
    </a>
@endsection

@push('styles')
    <style>
        :root {
            --bg0: #050a06; --bg1: #0c1410; --bg2: #121d16;
            --b0: rgba(16, 185, 129, 0.08); --b1: rgba(16, 185, 129, 0.2);
            --tx0: #f4f4f5; --tx1: #71717a; --g0: #10b981;
        }

        .ot-wrap { background: var(--bg0); min-height: 100vh; padding: 24px; position: relative; font-family: 'Hind Siliguri', sans-serif; color: var(--tx0); }
        
        /* Glassmorphism Stats Card */
        .stat-card { background: linear-gradient(145deg, var(--bg1), #08100c); border: 1px solid var(--b0); border-radius: 24px; padding: 20px; position: relative; overflow: hidden; }
        .stat-card::after { content: ''; position: absolute; top: -50%; right: -50%; width: 100%; height: 100%; background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%); }

        .ot-card { background: var(--bg1); border: 1px solid var(--b0); border-radius: 32px; backdrop-filter: blur(12px); overflow: hidden; }
        .ot-input { background: #040805; border: 1px solid var(--b0); border-radius: 18px; color: var(--tx0); transition: all 0.2s; padding: 12px 20px; }
        .ot-input:focus { border-color: var(--g0); outline: none; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }

        .ot-btn-primary { background: linear-gradient(135deg, var(--g0), #059669); color: #050a06; padding: 10px 24px; border-radius: 14px; font-weight: 800; display: inline-flex; align-items: center; gap: 8px; }
        .font-data { font-family: 'JetBrains Mono', monospace; }

        .price-low { color: #10b981; text-shadow: 0 0 12px rgba(16, 185, 129, 0.2); }
        .price-high { color: #f43f5e; text-shadow: 0 0 12px rgba(244, 63, 94, 0.2); }

        @media (max-width: 768px) {
            .ot-wrap {
                padding: 14px 10px;
            }

            .ot-card {
                border-radius: 24px;
            }

            .ot-btn-primary {
                width: 100%;
                justify-content: center;
            }

            table.w-full {
                min-width: 760px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ot-wrap">
        <div class="max-w-7xl mx-auto relative z-10 space-y-6">

            {{-- ১. স্মার্ট সামারি (New Feature) --}}
            @if(!$prices->isEmpty())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="stat-card">
                    <p class="text-[10px] font-data font-bold text-zinc-500 uppercase tracking-widest mb-1">সর্বনিম্ন বাজার দর</p>
                    <h3 class="text-3xl font-black text-emerald-400 font-data">৳{{ number_format($prices->min('price')) }}</h3>
                    <div class="mt-2 text-[9px] text-zinc-600 font-bold uppercase tracking-tighter">Current Range: {{ $from ?? 'All' }}</div>
                </div>
                <div class="stat-card">
                    <p class="text-[10px] font-data font-bold text-zinc-500 uppercase tracking-widest mb-1">গড় বাজার দর</p>
                    <h3 class="text-3xl font-black text-white font-data">৳{{ number_format($prices->avg('price')) }}</h3>
                    <div class="mt-2 text-[9px] text-emerald-500 font-bold uppercase tracking-tighter">Stable Market Condition</div>
                </div>
                <div class="stat-card">
                    <p class="text-[10px] font-data font-bold text-zinc-500 uppercase tracking-widest mb-1">সর্বোচ্চ বাজার দর</p>
                    <h3 class="text-3xl font-black text-rose-500 font-data">৳{{ number_format($prices->max('price')) }}</h3>
                    <div class="mt-2 text-[9px] text-zinc-600 font-bold uppercase tracking-tighter">Peak Resistance Point</div>
                </div>
            </div>
            @endif

            {{-- ২. ফিল্টার টার্মিনাল --}}
            <div class="ot-card p-4">
                <form method="GET" class="flex flex-wrap lg:flex-nowrap gap-4 items-center">
                    <div class="relative flex-1 min-w-[200px]">
                        <select name="market_id" class="ot-input w-full appearance-none cursor-pointer text-zinc-400">
                            <option value="">সব বাজার</option>
                            @foreach($markets as $market)
                                <option value="{{ $market->id }}" {{ $marketId == $market->id ? 'selected' : '' }}>{{ $market->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-3 bg-zinc-950 border border-white/5 rounded-2xl px-5 py-3">
                        <input type="date" name="from" value="{{ $from }}" class="bg-transparent text-[10px] font-data font-bold text-zinc-500 uppercase">
                        <span class="text-zinc-800 text-xs">TO</span>
                        <input type="date" name="to" value="{{ $to }}" class="bg-transparent text-[10px] font-data font-bold text-zinc-500 uppercase">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-8 py-3.5 bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 rounded-2xl text-sm font-black text-white transition-all">ফিল্টার</button>
                        @if($marketId || $from || $to)
                            <a href="{{ route('prices.index') }}" class="px-5 py-3.5 bg-zinc-950 border border-white/5 rounded-2xl text-zinc-500 text-sm font-bold">রিসেট</a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ৩. মেইন প্রাইস লেজার --}}
            <div class="ot-card">
                <div class="px-8 py-6 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                    <div class="flex items-center gap-4">
                        <div class="w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_15px_rgba(16,185,129,0.4)]"></div>
                        <h2 class="text-xl font-extrabold text-white font-['Bricolage_Grotesque']">রেকর্ডকৃত বাজার দর</h2>
                    </div>
                </div>

                @if($prices->isEmpty())
                    <div class="py-32 text-center">
                        <h3 class="text-zinc-500 font-bold text-xl">কোনো তথ্য পাওয়া যায়নি</h3>
                    </div>
                @else
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-left">
                                            <thead>
                                                <tr class="bg-zinc-950/40 text-[10px] font-data font-bold uppercase tracking-[0.2em] text-zinc-600 border-b border-white/5">
                                                    <th class="px-8 py-6">বাজার ও অবস্থান</th>
                                                    <th class="px-6 py-6 text-center">রেকর্ড তারিখ</th>
                                                    <th class="px-6 py-6">মূল্য (কেজি প্রতি)</th>
                                                    <th class="px-6 py-6 text-right">স্ট্যাটাস</th>
                                                    <th class="px-8 py-6 text-right">অ্যাকশন</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-white/[0.03]">
                                                @php
                    $minP = $prices->min('price');
                    $maxP = $prices->max('price');
                                                @endphp
                                                @foreach($prices as $price)
                                                    <tr class="hover:bg-white/[0.01] transition-all group">
                                                        <td class="px-8 py-6">
                                                            <div class="flex items-center gap-4">
                                                                <div class="w-2 h-2 rounded-full {{ $price->price == $minP ? 'bg-emerald-500 shadow-[0_0_8px_#10b981]' : ($price->price == $maxP ? 'bg-rose-500 shadow-[0_0_8px_#f43f5e]' : 'bg-zinc-800') }}"></div>
                                                                <div>
                                                                    <div class="text-base font-bold text-white group-hover:text-emerald-400 transition-colors">{{ $price->market?->name }}</div>
                                                                    <div class="text-[9px] font-data font-bold text-zinc-700 uppercase">{{ $price->market?->division ?? 'PialMahmud_Core' }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-6 text-center">
                                                            <span class="px-4 py-2 rounded-xl bg-zinc-950 border border-white/5 text-xs font-data text-zinc-400">{{ $price->formatted_date }}</span>
                                                        </td>
                                                        <td class="px-6 py-6">
                                                            <div class="flex items-baseline gap-1.5">
                                                                <span class="text-xl font-black font-data {{ $price->price == $minP ? 'price-low' : ($price->price == $maxP ? 'price-high' : 'text-zinc-100') }}">
                                                                    ৳{{ number_format($price->price) }}
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-6 text-right">
                                                            @if($price->price == $minP)
                                                                <span class="text-[9px] font-black uppercase bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 px-3 py-1 rounded-lg">Best Deal</span>
                                                            @elseif($price->price == $maxP)
                                                                <span class="text-[9px] font-black uppercase bg-rose-500/10 text-rose-500 border border-rose-500/20 px-3 py-1 rounded-lg">Peak Price</span>
                                                            @else
                                                                <span class="text-[9px] font-bold text-zinc-700 uppercase">Average</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-8 py-6">
                                                            <div class="flex justify-end gap-3">
                                                                <a href="{{ route('prices.edit', $price) }}" class="p-2 bg-zinc-950 border border-white/5 rounded-xl text-zinc-600 hover:text-emerald-400">✎</a>
                                                                <form action="{{ route('prices.destroy', $price) }}" method="POST">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" class="p-2 bg-zinc-950 border border-white/5 rounded-xl text-zinc-800 hover:text-rose-500">✕</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @if($prices->hasPages())
                                    <div class="px-8 py-6 border-t border-white/5 bg-zinc-950/30">
                                        <div class="flex items-center justify-between">
                                            <div class="flex gap-4 w-full justify-between">
                                                @if ($prices->onFirstPage())
                                                    <span
                                                        class="px-6 py-2.5 rounded-xl bg-zinc-900/50 border border-white/5 text-zinc-800 text-[10px] font-data font-bold uppercase tracking-widest cursor-not-allowed">
                                                        Previous
                                                    </span>
                                                @else
                                                    <a href="{{ $prices->previousPageUrl() }}"
                                                        class="px-6 py-2.5 rounded-xl bg-zinc-900 border border-white/10 text-zinc-400 text-[10px] font-data font-bold uppercase tracking-widest hover:text-emerald-400 hover:border-emerald-500/30 transition-all">
                                                        ← Previous
                                                    </a>
                                                @endif

                                                @if ($prices->hasMorePages())
                                                    <a href="{{ $prices->nextPageUrl() }}"
                                                        class="px-6 py-2.5 rounded-xl bg-zinc-900 border border-white/10 text-zinc-400 text-[10px] font-data font-bold uppercase tracking-widest hover:text-emerald-400 hover:border-emerald-500/30 transition-all">
                                                        Next →
                                                    </a>
                                                @else
                                                    <span
                                                        class="px-6 py-2.5 rounded-xl bg-zinc-900/50 border border-white/5 text-zinc-800 text-[10px] font-data font-bold uppercase tracking-widest cursor-not-allowed">
                                                        Next
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                @endif
            </div>
        </div>
    </div>
@endsection
