@extends('layouts.app')

@section('title', 'নতুন সদস্য')

@push('styles')
    <style>
        @media (max-width: 768px) {
            .member-create-wrap {
                padding: 14px 10px;
            }

            .member-create-wrap .form-shell {
                border-radius: 22px;
                padding: 18px 14px;
            }

            .member-create-wrap .actions-row > * {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="member-create-wrap min-h-screen bg-zinc-950 p-5 md:p-8 relative overflow-x-hidden font-['Bricolage_Grotesque'] text-zinc-100">
    
    <div class="fixed inset-0 pointer-events-none z-0" style="background-image: linear-gradient(rgba(52,211,153,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(52,211,153,0.02) 1px, transparent 1px); background-size: 52px 52px;"></div>
    
    <div class="relative z-10 max-w-2xl mx-auto">
        
        <div class="mb-8">
            <a href="{{ route('members.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold tracking-widest uppercase text-zinc-500 hover:text-emerald-400 transition-colors mb-4">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                সদস্য তালিকায় ফিরে যান
            </a>
            <h1 class="text-3xl font-extrabold tracking-tight text-white">
                নতুন সদস্য যোগ করুন
            </h1>
            <p class="text-sm text-zinc-500 mt-2 font-medium">তথ্য সংগ্রহ ও বাজার মনিটরিংয়ের জন্য নতুন প্রতিনিধি যুক্ত করুন।</p>
        </div>

        <div class="form-shell rounded-[32px] bg-zinc-900 border border-zinc-800 p-6 md:p-10 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 blur-3xl rounded-full -mr-20 -mt-20 pointer-events-none"></div>

            <form action="{{ route('members.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 gap-8">
                    
                    {{-- Name --}}
                    <div class="space-y-2">
                        <label class="block font-['JetBrains_Mono'] text-[11px] font-bold uppercase tracking-widest text-zinc-500 ml-1">
                            সদস্যের নাম <span class="text-emerald-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                               placeholder="যেমন: মোঃ আব্দুল করিম"
                               class="w-full bg-zinc-950 border border-zinc-800 text-zinc-100 px-5 py-4 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500/50 transition-all placeholder:text-zinc-800 @error('name') border-rose-500/50 ring-2 ring-rose-500/10 @enderror">
                        @error('name')<p class="text-rose-400 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>@enderror
                    </div>

                    {{-- Phone Number --}}
                    <div class="space-y-2">
                        <label class="block font-['JetBrains_Mono'] text-[11px] font-bold uppercase tracking-widest text-zinc-500 ml-1">
                            মোবাইল নম্বর <span class="text-emerald-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="017XXXXXXXX" required
                                   class="w-full bg-zinc-950 border border-zinc-800 text-zinc-100 px-5 py-4 rounded-2xl text-sm font-['JetBrains_Mono'] focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500/50 transition-all placeholder:text-zinc-800 @error('phone') border-rose-500/50 @enderror">
                        </div>
                        <p class="text-[10px] text-zinc-600 font-bold uppercase tracking-wider ml-1">যেমন: 01712345678</p>
                        @error('phone')<p class="text-rose-400 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>@enderror
                    </div>

                    {{-- Market Assignment --}}
                    <div class="space-y-2">
                        <label class="block font-['JetBrains_Mono'] text-[11px] font-bold uppercase tracking-widest text-zinc-500 ml-1">
                            নিযুক্ত বাজার <span class="text-emerald-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="market_id" id="market_id" required
                                    class="w-full bg-zinc-950 border border-zinc-800 text-zinc-100 px-5 py-4 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500/50 transition-all appearance-none cursor-pointer @error('market_id') border-rose-500/50 @enderror">
                                <option value="" class="text-zinc-500">বাজার নির্বাচন করুন</option>
                                @foreach($markets as $market)
                                    <option value="{{ $market->id }}" {{ old('market_id') == $market->id ? 'selected' : '' }}>
                                        {{ $market->name }} ({{ $market->division }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-500">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </div>
                        </div>
                        @error('market_id')<p class="text-rose-400 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>@enderror
                    </div>

                    {{-- Active Status Toggle --}}
                    <div class="pt-2">
                        <label class="inline-flex items-center gap-4 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-zinc-800 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </div>
                            <span class="text-sm font-bold text-zinc-300 group-hover:text-white transition-colors">সদস্য বর্তমানে সক্রিয়</span>
                        </label>
                    </div>
                </div>

                <div class="actions-row flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-zinc-950 font-black text-sm shadow-xl shadow-emerald-500/20 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        সংরক্ষণ করুন
                    </button>
                    <a href="{{ route('members.index') }}"
                       class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-zinc-950 border border-zinc-800 text-zinc-400 font-bold text-sm hover:bg-zinc-800 hover:text-white transition-all">
                        বাতিল
                    </a>
                </div>
            </form>
        </div>
        
        <p class="mt-8 text-center text-[10px] font-['JetBrains_Mono'] font-bold text-zinc-700 uppercase tracking-[0.2em]">
            System Node: PialMahmud_Core // Access Level: Admin
        </p>
    </div>
</div>
@endsection
