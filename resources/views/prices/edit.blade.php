@extends('layouts.app')

@section('title', 'দাম রেকর্ড আপডেট')

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

        .ot-btn-update {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #050a06;
            padding: 16px 32px;
            border-radius: 20px;
            font-weight: 900;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 15px 30px -10px rgba(16, 185, 129, 0.4);
        }

        .ot-btn-update:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
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

            {{-- Header Zone --}}
            <div class="mb-10">
                <a href="{{ route('prices.index') }}"
                    class="group inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-zinc-600 hover:text-emerald-400 transition-all mb-6">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    <span>রেকর্ড তালিকায় ফিরে যান</span>
                </a>
                <h1 class="text-4xl font-extrabold tracking-tighter text-white font-['Bricolage_Grotesque']">
                    রেকর্ড আপডেট করুন
                </h1>
                <p class="text-sm text-zinc-600 mt-2 font-medium">বিদ্যমান মূল্য রেকর্ড সংশোধন করে লেজার আপডেট করুন।</p>
            </div>

            {{-- Form Card --}}
            <div class="ot-card p-8 md:p-12 relative overflow-hidden">
                {{-- Aesthetic Glow --}}
                <div
                    class="absolute top-0 right-0 w-80 h-80 bg-emerald-500/5 blur-[100px] -mr-40 -mt-40 pointer-events-none">
                </div>

                <form action="{{ route('prices.update', $price) }}" method="POST" class="space-y-10 relative z-10">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-10">

                        {{-- Market Selector --}}
                        <div class="md:col-span-2 group">
                            <label class="ot-label">বাজার <span class="text-emerald-500">*</span></label>
                            <div class="relative">
                                <select name="market_id" id="market_id" required
                                    class="ot-input appearance-none cursor-pointer @error('market_id') border-rose-500/50 @enderror">
                                    @foreach($markets as $market)
                                        <option value="{{ $market->id }}" {{ old('market_id', $price->market_id) == $market->id ? 'selected' : '' }}>
                                            {{ $market->name }} ({{ $market->division }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-700">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="4">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </div>
                            </div>
                            @error('market_id') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">
                                {{ $message }}
                            </p> @enderror
                        </div>

                        {{-- Price Input --}}
                        <div>
                            <label class="ot-label">মূল্য <span class="text-emerald-500">*</span></label>
                            <div class="relative group">
                                <span
                                    class="absolute left-6 top-1/2 -translate-y-1/2 text-emerald-500 font-bold font-data">৳</span>
                                <input type="number" name="price" value="{{ old('price', $price->price) }}" step="0.01"
                                    min="0" required
                                    class="ot-input pl-12 text-xl font-data font-bold @error('price') border-rose-500/50 @enderror">
                            </div>
                            @error('price') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">
                                {{ $message }}
                            </p> @enderror
                        </div>

                        {{-- Unit Selector --}}
                        <div>
                            <label class="ot-label">পরিমাপ একক</label>
                            <div class="relative">
                                <select name="unit" id="unit" class="ot-input appearance-none cursor-pointer">
                                    <option value="KG" {{ old('unit', $price->unit) == 'KG' ? 'selected' : '' }}>কেজি (KG)
                                    </option>
                                    <option value="Maund" {{ old('unit', $price->unit) == 'Maund' ? 'selected' : '' }}>মণ
                                        (Maund)</option>
                                    <option value="100KG" {{ old('unit', $price->unit) == '100KG' ? 'selected' : '' }}>১০০
                                        কেজি (100KG)</option>
                                </select>
                                <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-700">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="4">
                                        <path d="m6 9 6 6 6-6" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Date Picker --}}
                        <div class="md:col-span-2">
                            <label class="ot-label">রেকর্ড তারিখ <span class="text-emerald-500">*</span></label>
                            <input type="date" name="date" value="{{ old('date', $price->date->format('Y-m-d')) }}" required
                                class="ot-input font-data font-bold text-zinc-400 @error('date') border-rose-500/50 @enderror">
                            @error('date') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 uppercase">{{ $message }}
                            </p> @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="md:col-span-2">
                            <label class="ot-label">অতিরিক্ত তথ্য (ঐচ্ছিক)</label>
                            <textarea name="notes" rows="4" placeholder="বিশেষ পরিস্থিতি সম্পর্কে লিখুন..."
                                class="ot-input resize-none placeholder:text-zinc-800">{{ old('notes', $price->notes) }}</textarea>
                        </div>
                    </div>

                    {{-- Action Group --}}
                    <div class="flex flex-col sm:flex-row gap-5 pt-8">
                        <button type="submit" class="ot-btn-update flex-1">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="3">
                                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7" />
                                <polyline points="16 5 21 5 21 10" />
                                <line x1="12" y1="12" x2="21" y2="3" />
                            </svg>
                            <span>পরিবর্তন সংরক্ষণ করুন</span>
                        </button>
                        <a href="{{ route('prices.index') }}"
                            class="inline-flex items-center justify-center px-10 py-5 rounded-2xl bg-zinc-950 border border-zinc-800 text-zinc-500 font-bold text-sm hover:bg-zinc-900 hover:text-white transition-all">
                            বাতিল
                        </a>
                    </div>
                </form>
            </div>

            {{-- Meta Footer --}}
            <div class="mt-12 text-center">
                <p class="text-[10px] font-data font-bold text-zinc-800 uppercase tracking-[0.4em]">
                    System Node: PialMahmud_Core // Record ID: {{ $price->id }}
                </p>
            </div>
        </div>
    </div>
@endsection
