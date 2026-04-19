@extends('layouts.app')

@section('title', 'দাম রেকর্ড করুন')

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;600;800&family=JetBrains+Mono:wght@400;700&family=Hind+Siliguri:wght@400;600;700&display=swap"
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
            --g0: #10b981;
        }

        .ot-wrap {
            background: var(--bg0);
            min-height: 100vh;
            padding: 24px;
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
            border-radius: 40px;
            backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .ot-label {
            font-family: 'JetBrains Mono', monospace;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--tx1);
            margin-left: 4px;
            margin-bottom: 8px;
            display: block;
        }

        .ot-input {
            background: #040805;
            border: 1px solid var(--b0);
            border-radius: 20px;
            color: var(--tx0);
            padding: 16px 20px;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .ot-input:focus {
            border-color: var(--g0);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
            background: #060c08;
        }

        .font-data {
            font-family: 'JetBrains Mono', monospace;
        }

        @media (max-width: 768px) {
            .ot-wrap {
                padding: 14px 10px;
            }

            .ot-card {
                border-radius: 24px;
            }

            .ot-input {
                border-radius: 16px;
                padding: 14px 16px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ot-wrap">
        <div class="max-w-2xl mx-auto relative z-10 pt-8 pb-20">

            {{-- Header --}}
            <div class="mb-10">
                <a href="{{ route('prices.index') }}"
                    class="group inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-zinc-600 hover:text-emerald-400 transition-all mb-6">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    <span>রেকর্ড তালিকায় ফিরে যান</span>
                </a>
                <h1 class="text-4xl font-extrabold tracking-tighter text-white font-['Bricolage_Grotesque']">
                    নতুন দাম রেকর্ড করুন
                </h1>
                <p class="text-sm text-zinc-600 mt-2 font-medium">বাজারের বর্তমান মূল্য হালনাগাদ করে সিস্টেম আপডেট করুন।</p>
            </div>

            {{-- Form Card --}}
            <div class="ot-card p-8 md:p-12 relative overflow-hidden" x-data="{ step: 1, totalSteps: 2 }" x-cloak>

                {{-- Glow --}}
                <div
                    class="absolute top-0 right-0 w-80 h-80 bg-emerald-500/5 blur-[100px] -mr-40 -mt-40 pointer-events-none">
                </div>

                {{-- Progress Bar --}}
                <div class="mb-8 flex gap-2">
                    <template x-for="i in totalSteps">
                        <div class="h-1 flex-1 rounded-full transition-all duration-500"
                            :class="step >= i ? 'bg-emerald-500' : 'bg-zinc-800'"></div>
                    </template>
                </div>

                {{-- Step Label --}}
                <p class="text-[10px] font-data font-bold uppercase tracking-widest text-zinc-600 mb-8">
                    ধাপ <span x-text="step"></span> / <span x-text="totalSteps"></span>
                </p>

                <form action="{{ route('prices.store') }}" method="POST" class="space-y-8 relative z-10">
                    @csrf

                    {{-- Step 1: Market & Date --}}
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4">
                        <div class="space-y-8">
                            <div>
                                <label class="ot-label">বাজার নির্বাচন <span class="text-emerald-500">*</span></label>
                                <select name="market_id" required class="ot-input">
                                    @foreach($markets as $market)
                                        <option value="{{ $market->id }}">{{ $market->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="ot-label">রেকর্ড তারিখ <span class="text-emerald-500">*</span></label>
                                <input type="date" name="date" value="{{ $today }}" required class="ot-input font-data">
                            </div>
                        </div>

                        {{-- Next Button --}}
                        <div class="flex gap-4 mt-10">
                            <button type="button" @click="step = 2"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-zinc-950 font-black text-sm shadow-xl shadow-emerald-500/20 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                                পরবর্তী
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </button>
                            <a href="{{ route('prices.index') }}"
                                class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-zinc-950 border border-zinc-800 text-zinc-400 font-bold text-sm hover:bg-zinc-800 hover:text-white transition-all">
                                বাতিল
                            </a>
                        </div>
                    </div>

                    {{-- Step 2: Price, Unit, Notes --}}
                    <div x-show="step === 2" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-x-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="ot-label">মূল্য <span class="text-emerald-500">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-500 font-bold font-data">৳</span>
                                    <input type="number" name="price" required min="0" step="0.01"
                                        class="ot-input pl-12 text-xl font-data font-bold">
                                </div>
                            </div>
                            <div>
                                <label class="ot-label">পরিমাপ একক</label>
                                <select name="unit" class="ot-input">
                                    <option value="KG">কেজি (KG)</option>
                                    <option value="Maund">মণ (Maund)</option>
                                    <option value="100KG">১০০ কেজি (100KG)</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="ot-label">অতিরিক্ত তথ্য (ঐচ্ছিক)</label>
                                <textarea name="notes" rows="4" placeholder="বিশেষ পরিস্থিতি সম্পর্কে লিখুন..."
                                    class="ot-input resize-none placeholder:text-zinc-800"></textarea>
                            </div>
                        </div>

                        {{-- Back + Submit --}}
                        <div class="flex flex-col sm:flex-row gap-4 mt-10">
                            <button type="button" @click="step = 1"
                                class="inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-zinc-950 border border-zinc-800 text-zinc-400 font-bold text-sm hover:bg-zinc-800 hover:text-white transition-all">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3">
                                    <path d="m15 18-6-6 6-6" />
                                </svg>
                                পূর্ববর্তী
                            </button>
                            <button type="submit"
                                class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-zinc-950 font-black text-sm shadow-xl shadow-emerald-500/20 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                সংরক্ষণ করুন
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection