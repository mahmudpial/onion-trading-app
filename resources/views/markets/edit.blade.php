@extends('layouts.app')

@section('title', 'বাজার সম্পাদনা')

@push('styles')
    <style>
        @media (max-width: 768px) {
            .market-edit-wrap {
                padding: 14px 10px;
            }

            .market-edit-wrap .form-shell {
                border-radius: 22px;
                padding: 18px 14px;
            }

            .market-edit-wrap .actions-row > * {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
<div class="market-edit-wrap min-h-screen bg-zinc-950 p-5 md:p-8 relative overflow-x-hidden font-['Bricolage_Grotesque'] text-zinc-100">
    
    <div class="fixed inset-0 pointer-events-none z-0" style="background-image: linear-gradient(rgba(52,211,153,0.02) 1px, transparent 1px), linear-gradient(90deg, rgba(52,211,153,0.02) 1px, transparent 1px); background-size: 52px 52px;"></div>
    
    <div class="relative z-10 max-w-2xl mx-auto">
        
        <div class="mb-8 text-center sm:text-left">
            <a href="{{ route('markets.index') }}" class="inline-flex items-center gap-2 text-[10px] font-bold tracking-widest uppercase text-zinc-500 hover:text-emerald-400 transition-colors mb-4">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                তালিকায় ফিরে যান
            </a>
            <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white leading-tight">
                বাজার সম্পাদনা করুন
            </h1>
            <p class="text-sm text-zinc-500 mt-2 font-medium">বর্তমান বাজার: <span class="text-emerald-500 font-bold">{{ $market->name }}</span></p>
        </div>

        <div class="form-shell rounded-[32px] bg-zinc-900 border border-zinc-800 p-6 md:p-10 shadow-2xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/5 blur-3xl rounded-full -mr-20 -mt-20 pointer-events-none"></div>

            <form action="{{ route('markets.update', $market) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-8">
                    
                    {{-- Market Name --}}
                    <div class="space-y-2">
                        <label class="block font-['JetBrains_Mono'] text-[11px] font-bold uppercase tracking-widest text-zinc-500 ml-1">
                            বাজারের নাম <span class="text-emerald-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $market->name) }}" required
                               class="w-full bg-zinc-950 border border-zinc-800 text-zinc-100 px-5 py-4 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500/50 transition-all placeholder:text-zinc-700 @error('name') border-rose-500/50 ring-2 ring-rose-500/10 @enderror">
                        @error('name')<p class="text-rose-400 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>@enderror
                    </div>

                    {{-- Division Selection --}}
                    <div class="space-y-2">
                        <label class="block font-['JetBrains_Mono'] text-[11px] font-bold uppercase tracking-widest text-zinc-500 ml-1">
                            বিভাগ <span class="text-emerald-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="division" id="division" required
                                    class="w-full bg-zinc-950 border border-zinc-800 text-zinc-100 px-5 py-4 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500/50 transition-all appearance-none cursor-pointer @error('division') border-rose-500/50 @enderror">
                                <option value="">বিভাগ নির্বাচন করুন</option>
                                @foreach($divisions as $division)
                                    <option value="{{ $division }}" {{ old('division', $market->division) == $division ? 'selected' : '' }}>{{ $division }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-500">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            </div>
                        </div>
                        @error('division')<p class="text-rose-400 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>@enderror
                    </div>

                    {{-- Open Days Interactive Chips --}}
                    <div class="space-y-4">
                        <label class="block font-['JetBrains_Mono'] text-[11px] font-bold uppercase tracking-widest text-zinc-500 ml-1">
                            সাপ্তাহিক খোলার দিন
                        </label>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($weekdays as $day)
                            <label class="cursor-pointer group">
                                <input type="checkbox" name="open_days[]" value="{{ $day }}" 
                                    {{ in_array($day, old('open_days', $market->open_days ?? [])) ? 'checked' : '' }}
                                    class="sr-only peer">
                                <div class="px-4 py-2.5 rounded-xl border border-zinc-800 bg-zinc-950 text-xs font-bold text-zinc-500 transition-all 
                                            peer-checked:bg-emerald-500/10 peer-checked:border-emerald-500/40 peer-checked:text-emerald-400
                                            group-hover:border-zinc-700 select-none uppercase tracking-tight">
                                    {{ substr($day, 0, 3) }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                        @error('open_days')<p class="text-rose-400 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>@enderror
                    </div>

                    {{-- Notes / Remarks --}}
                    <div class="space-y-2">
                        <label class="block font-['JetBrains_Mono'] text-[11px] font-bold uppercase tracking-widest text-zinc-500 ml-1">
                            মন্তব্য
                        </label>
                        <textarea name="notes" id="notes" rows="3" 
                                  class="w-full bg-zinc-950 border border-zinc-800 text-zinc-100 px-5 py-4 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500/50 transition-all resize-none placeholder:text-zinc-800"
                                  placeholder="বাজার সম্পর্কে অতিরিক্ত কোনো তথ্য থাকলে এখানে লিখুন...">{{ old('notes', $market->notes) }}</textarea>
                    </div>

                    {{-- Modern Status Toggle --}}
                    <div class="pt-2">
                        <label class="inline-flex items-center gap-4 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $market->is_active) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="w-11 h-6 bg-zinc-800 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                            </div>
                            <span class="text-sm font-bold text-zinc-300 group-hover:text-white transition-colors">এই বাজারটি বর্তমানে সক্রিয় হিসেবে সেট করা</span>
                        </label>
                    </div>
                </div>

                <div class="actions-row flex flex-col sm:flex-row gap-4 pt-6">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 text-zinc-950 font-black text-sm shadow-xl shadow-emerald-500/20 hover:-translate-y-0.5 active:translate-y-0 transition-all">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                        আপডেট নিশ্চিত করুন
                    </button>
                    <a href="{{ route('markets.index') }}" 
                       class="inline-flex items-center justify-center px-8 py-4 rounded-2xl bg-zinc-950 border border-zinc-800 text-zinc-400 font-bold text-sm hover:bg-zinc-800 hover:text-white transition-all">
                        বাতিল
                    </a>
                </div>
            </form>
        </div>
        
        <p class="mt-8 text-center text-[10px] font-['JetBrains_Mono'] font-bold text-zinc-700 uppercase tracking-[0.2em]">
            System Node: PialMahmud_Core // Market Identity Management
        </p>
    </div>
</div>
@endsection
