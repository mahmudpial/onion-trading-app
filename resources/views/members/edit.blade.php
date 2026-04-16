@extends('layouts.app')

@section('title', 'সদস্য সম্পাদনা')
@section('page-title', '✍️ সদস্য তথ্য পরিবর্তন')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,400;600;800&family=JetBrains+Mono:wght@400;700&family=Hind+Siliguri:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --bg0: #050a06;
            --bg1: #0c1410;
            --g0: #10b981;
            --b0: rgba(16, 185, 129, 0.08);
        }

        .ot-wrap {
            background: var(--bg0);
            min-height: 100vh;
            padding: 24px;
            position: relative;
            font-family: 'Hind Siliguri', sans-serif;
            color: #f4f4f5;
        }

        .ot-wrap::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background-image: linear-gradient(rgba(16, 185, 129, 0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(16, 185, 129, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            mask-image: radial-gradient(circle at center, black, transparent 80%);
        }

        .ot-card {
            background: var(--bg1);
            border: 1px solid var(--b0);
            border-radius: 32px;
            backdrop-filter: blur(12px);
            padding: 40px;
            max-width: 600px;
            margin: 0 auto;
        }

        .ot-input {
            background: #040805;
            border: 1px solid var(--b0);
            border-radius: 16px;
            color: #fff;
            padding: 14px 18px;
            width: 100%;
            transition: 0.2s;
        }

        .ot-input:focus {
            border-color: var(--g0);
            outline: none;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .label-text {
            color: #71717a;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 8px;
            display: block;
        }

        @media (max-width: 768px) {
            .ot-wrap {
                padding: 14px 10px;
            }

            .ot-card {
                padding: 22px 16px;
                border-radius: 22px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ot-wrap">
        <div class="ot-card relative z-10 shadow-2xl">
            <form action="{{ route('members.update', $member) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Name Field --}}
                <div>
                    <label class="label-text">সদস্যের নাম</label>
                    <input type="text" name="name" value="{{ old('name', $member->name) }}" class="ot-input" required>
                    @error('name') <p class="text-rose-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Phone Field --}}
                <div>
                    <label class="label-text">ফোন নম্বর</label>
                    <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" class="ot-input font-mono"
                        required>
                    @error('phone') <p class="text-rose-500 text-xs mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- Market Selection --}}
                <div>
                    <label class="label-text">নির্ধারিত বাজার</label>
                    <select name="market_id" class="ot-input appearance-none cursor-pointer">
                        @foreach($markets as $market)
                            <option value="{{ $market->id }}" {{ $member->market_id == $market->id ? 'selected' : '' }}>
                                {{ $market->name }} ({{ $market->division }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit"
                        class="flex-1 py-4 bg-emerald-500 hover:bg-emerald-400 text-zinc-950 font-black rounded-2xl transition-all shadow-lg shadow-emerald-500/20">
                        তথ্য আপডেট করুন
                    </button>
                    <a href="{{ route('members.index') }}"
                        class="px-8 py-4 bg-zinc-800 text-zinc-400 font-bold rounded-2xl hover:bg-zinc-700 transition-all">
                        বাতিল
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
