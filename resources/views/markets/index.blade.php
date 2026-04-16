@extends('layouts.app')

@section('title', 'বাজার তালিকা')
@section('page-title', '🏪 বাজার ড্যাশবোর্ড')

@section('topbar-actions')
    {{-- ১. মূল ক্রিয়েট বাটন (টপবার) --}}
    <button onclick="toggleModal('marketModal')" class="ot-btn-primary group">
        <svg class="group-hover:rotate-90 transition-transform" width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="3" stroke-linecap="round">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        <span>নতুন বাজার যোগ করুন</span>
    </button>
@endsection

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;600;800&family=JetBrains+Mono:wght@400;700&family=Hind+Siliguri:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* ─── PREMIUM DESIGN SYSTEM ──────────────────────────────── */
        :root {
            --bg0: #050a06;
            --bg1: #0c1410;
            --b0: rgba(16, 185, 129, 0.1);
            --g0: #10b981;
        }

        .ot-wrap {
            background: var(--bg0);
            min-height: 100vh;
            padding: 32px 24px;
            font-family: 'Hind Siliguri', sans-serif;
            color: #f4f4f5;
            position: relative;
        }

        .ot-wrap::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: radial-gradient(circle at 2px 2px, rgba(16, 185, 129, 0.05) 1px, transparent 0);
            background-size: 32px 32px;
        }

        .ot-card {
            background: linear-gradient(165deg, var(--bg1), #080e0a);
            border: 1px solid var(--b0);
            border-radius: 24px;
            backdrop-filter: blur(10px);
        }

        .font-data {
            font-family: 'JetBrains Mono', monospace;
        }

        .ot-input {
            background: #040805 !important;
            border: 1px solid var(--b0) !important;
            border-radius: 14px !important;
            color: #fff !important;
        }

        .ot-btn-primary {
            background: linear-gradient(135deg, var(--g0), #059669);
            color: #050a06;
            padding: 10px 24px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .market-row {
            transition: all 0.2s;
            border-bottom: 1px solid rgba(255, 255, 255, 0.02);
        }

        .market-row:hover {
            background: rgba(16, 185, 129, 0.03);
        }

        /* ইন্টারেক্টিভ অ্যাকশন বক্স */
        .action-box {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: #040805;
            border: 1px solid var(--b0);
            transition: all 0.2s;
        }

        @media (max-width: 768px) {
            .ot-wrap {
                padding: 16px 12px;
            }

            .ot-card {
                border-radius: 20px;
            }

            .ot-btn-primary {
                width: 100%;
                justify-content: center;
            }

            .action-box {
                width: 34px;
                height: 34px;
            }

            table.w-full {
                min-width: 720px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ot-wrap">
        <div class="max-w-7xl mx-auto relative z-10 space-y-8">

            {{-- ২. স্মার্ট স্ট্যাটিস্টিকস কার্ড (৩-কলাম স্ট্যাট বার) --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="ot-card p-6 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest font-data">Total Markets</p>
                        <h3 class="text-3xl font-black text-white mt-1 font-data">{{ $markets->total() }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 text-xl">
                        🏪</div>
                </div>

                <div class="ot-card p-6 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest font-data">Active Divisions
                        </p>
                        <h3 class="text-3xl font-black text-white mt-1 font-data">{{ count($divisions) }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-500 text-xl">
                        📍</div>
                </div>

                <div class="ot-card p-6 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest font-data">Avg. Market Price
                        </p>
                        <h3 class="text-3xl font-black text-emerald-400 mt-1 font-data">
                            ৳{{ number_format($markets->avg('latest_price_value'), 1) }}</h3>
                    </div>
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 text-xl">
                        📈</div>
                </div>
            </div>

            {{-- ৩. স্লিকার টেবিল ডিজাইন & সার্চ বার --}}
            <div class="ot-card overflow-hidden">
                <div class="p-4 border-b border-white/5 flex flex-wrap gap-4 items-center justify-between bg-white/[0.01]">
                    <form method="GET" class="flex gap-3 flex-1">
                        <input name="search" value="{{ $search }}" placeholder="বাজার খুঁজুন..."
                            class="ot-input px-4 py-2.5 text-sm w-full md:w-80">
                        <button type="submit"
                            class="px-6 py-2.5 bg-zinc-800 rounded-xl text-xs font-bold text-white hover:bg-zinc-700 transition-all">Filter</button>
                    </form>

                    {{-- ফিল্টার বারের পাশেও একটি কুইক অ্যাড বাটন --}}
                    <button onclick="toggleModal('marketModal')"
                        class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-emerald-500/20 transition-all">
                        + কুইক অ্যাড
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr
                                class="text-[10px] font-data font-bold uppercase tracking-widest text-zinc-500 bg-white/[0.02]">
                                <th class="px-8 py-5">বাজার ও আইডি (Data Heavy)</th>
                                <th class="px-6 py-5">বিভাগ</th>
                                <th class="px-6 py-5">বর্তমান দর</th>
                                <th class="px-8 py-5 text-right">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($markets as $market)
                                <tr class="market-row group">
                                    <td class="px-8 py-6">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-10 h-10 rounded-xl bg-zinc-950 border border-white/5 flex items-center justify-center text-lg">
                                                🏪</div>
                                            <div>
                                                <h4 class="text-sm font-bold text-white">{{ $market->name }}</h4>
                                                <span
                                                    class="text-[10px] font-data font-bold text-emerald-500/40 uppercase">ID:{{ str_pad($market->id, 4, '0', STR_PAD_LEFT) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-6 text-xs font-bold text-zinc-400">{{ $market->division }}</td>
                                    <td class="px-6 py-6 font-data">
                                        <span
                                            class="text-sm font-bold text-emerald-400">৳{{ number_format($market->latest_price_value, 2) }}</span>
                                    </td>
                                    <td class="px-8 py-6">
                                        {{-- ৪. ছোট বর্গাকার অ্যাকশন বক্স --}}
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('markets.edit', $market) }}"
                                                class="action-box text-zinc-500 hover:text-emerald-400 hover:border-emerald-500/40">
                                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2.5">
                                                    <path d="M17 3l4 4L7 21H3v-4L17 3z" />
                                                </svg>
                                            </a>
                                            <form method="POST" action="{{ route('markets.destroy', $market) }}"
                                                onsubmit="return confirm('নিশ্চিত তো?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="action-box text-zinc-700 hover:text-rose-400 hover:border-rose-500/40">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2.5">
                                                        <path
                                                            d="M3 6h18m-2 0v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($markets->hasPages())
                    <div class="p-6 border-t border-white/5">
                        {{ $markets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- বাজার তৈরির আপডেট মোডাল --}}
    <div id="marketModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
        <div class="ot-card w-full max-w-xl p-8 border-emerald-500/20 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-black text-white">নতুন বাজার ও সময়সূচী</h2>
                    <p class="text-[10px] text-zinc-500 font-data">System Node: PialMahmud_Core</p>
                </div>
                <button onclick="toggleModal('marketModal')"
                    class="text-zinc-500 hover:text-white text-2xl">&times;</button>
            </div>

            <form action="{{ route('markets.store') }}" method="POST" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- নাম --}}
                    <div>
                        <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2 block">বাজারের
                            নাম</label>
                        <input type="text" name="name" required class="ot-input w-full px-4 py-3 text-sm focus:ring-0">
                    </div>
                    {{-- বিভাগ --}}
                    <div>
                        <label
                            class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2 block">বিভাগ</label>
                        <select name="division" class="ot-input w-full px-4 py-3 text-sm appearance-none">
                            @foreach(['Dhaka', 'Chittagong', 'Rajshahi', 'Khulna', 'Sylhet', 'Barisal', 'Rangpur', 'Mymensingh'] as $div)
                                <option value="{{ $div }}">{{ $div }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- টাইমিং --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2 block">খোলার
                            সময়</label>
                        <input type="time" name="opening_time" class="ot-input w-full px-4 py-3 text-sm">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2 block">বন্ধের
                            সময়</label>
                        <input type="time" name="closing_time" class="ot-input w-full px-4 py-3 text-sm">
                    </div>
                </div>

                {{-- সাপ্তাহিক বন্ধ (Multi-select) --}}
                <div>
                    <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mb-2 block">সাপ্তাহিক বন্ধের
                        দিন (সিলেক্ট করুন)</label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach(['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $day)
                            <label
                                class="flex items-center gap-2 bg-zinc-950 p-2 rounded-lg border border-white/5 cursor-pointer hover:border-emerald-500/30">
                                <input type="checkbox" name="off_days[]" value="{{ $day }}"
                                    class="rounded border-white/10 bg-zinc-900 text-emerald-500 focus:ring-0">
                                <span class="text-[10px] font-bold text-zinc-400 font-data">{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-emerald-500 text-black font-black py-4 rounded-xl hover:bg-emerald-400 transition-all shadow-lg">
                    বাজার তৈরি সম্পন্ন করুন
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            document.getElementById(id).classList.toggle('hidden');
        }

        @if($errors->any())
            toggleModal('marketModal');
        @endif
    </script>
@endsection
