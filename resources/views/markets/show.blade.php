@extends('layouts.app')

@section('title', $market->name . ' - Profile')

@push('styles')
    <style>
        @media (max-width: 768px) {
            .market-profile-title {
                font-size: 2.25rem;
                line-height: 1.1;
            }

            .market-profile-wrap .ot-card {
                border-radius: 20px;
                padding: 16px;
            }

            .market-profile-wrap .price-history-item {
                padding-left: 2.75rem;
            }

            .market-profile-wrap .timeline-line {
                left: 16px;
            }

            .market-profile-wrap .timeline-dot {
                left: 12px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ot-wrap market-profile-wrap" x-data="{ 
                uploading: false,
                fileName: '',
                triggerUpload() { this.$refs.fileInput.click() },
                handleFileChange(e) {
                    if(e.target.files[0]) {
                        this.fileName = e.target.files[0].name;
                    }
                }
            }">
        <div class="max-w-6xl mx-auto relative z-10">

            {{-- Header Section --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div>
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center gap-2 text-zinc-500 hover:text-emerald-400 transition-all text-[10px] font-black uppercase tracking-widest mb-4">
                        <span class="group-hover:-translate-x-1 transition-transform">←</span> BACK TO DASHBOARD
                    </a>
                    <h1 class="market-profile-title text-6xl font-black text-white tracking-tighter leading-none mb-2">{{ $market->name }}</h1>
                    <span
                        class="px-3 py-1 bg-emerald-500/10 text-emerald-500 rounded-full text-[10px] font-bold uppercase border border-emerald-500/20">
                        {{ $market->division }} DIVISION
                    </span>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('markets.edit', $market->id) }}"
                        class="px-6 py-3 bg-zinc-900 text-white rounded-2xl font-bold text-xs border border-white/5 hover:border-emerald-500/50 transition-all">
                        EDIT PROFILE
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left Column: Member & Files --}}
                <div class="space-y-6">

                    {{-- Member Card --}}
                    <div class="ot-card">
                        <div class="ot-label mb-6">REPRESENTATIVE</div>
                        @if($market->member)
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-20 h-20 rounded-[2rem] bg-emerald-500/10 flex items-center justify-center text-3xl font-black text-emerald-500 mb-4 border border-emerald-500/20 shadow-lg shadow-emerald-500/5">
                                    {{ mb_strtoupper(mb_substr($market->member->name, 0, 1)) }}
                                </div>
                                <h3 class="text-xl font-bold text-white">{{ $market->member->name }}</h3>
                                <p class="text-zinc-500 font-mono text-xs mt-1">{{ $market->member->phone }}</p>

                                <a href="tel:{{ $market->member->phone }}"
                                    class="mt-6 w-full py-4 bg-emerald-500 text-zinc-950 rounded-2xl font-black text-xs flex items-center justify-center gap-2 hover:scale-[1.02] active:scale-95 transition-all shadow-lg shadow-emerald-500/20">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                                    </svg>
                                    CALL NOW
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- Documents Card --}}
                    <div class="ot-card">
                        <div class="ot-label mb-6">DOCUMENTS (PDF ONLY)</div>
                        <div class="space-y-3 mb-6">
                            @forelse($market->documents as $doc)
                                <div
                                    class="flex items-center justify-between p-4 bg-zinc-950/50 rounded-2xl border border-white/5 group/file">
                                    <div class="flex items-center gap-3 overflow-hidden">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-zinc-900 flex items-center justify-center text-emerald-500 text-xs">
                                            PDF</div>
                                        <div class="truncate">
                                            <div class="text-[11px] font-bold text-zinc-200 truncate">{{ $doc->file_name }}
                                            </div>
                                            <div class="text-[9px] text-zinc-600 font-mono uppercase">
                                                {{ $doc->created_at->format('d M, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <a href="{{ route('documents.download', $doc->id) }}"
                                            class="p-2 text-zinc-500 hover:text-emerald-500 transition-colors">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                                                viewBox="0 0 24 24">
                                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('documents.destroy', $doc->id) }}" method="POST"
                                            onsubmit="return confirm('ফাইলটি কি ডিলিট করতে চান?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-zinc-500 hover:text-rose-500 transition-colors">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="py-10 text-center border-2 border-dashed border-white/5 rounded-2xl">
                                    <p class="text-[10px] text-zinc-600 font-bold uppercase tracking-widest">No Documents Found
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        {{-- Upload Area --}}
                        <form action="{{ route('markets.documents.store', $market->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            {{-- hidden input with x-ref --}}
                            <input type="file" name="document" x-ref="fileInput" id="document_input" class="hidden"
                                accept="application/pdf" @change="handleFileChange($event)">

                            {{-- Clickable Trigger Zone --}}
                            <div @click="$refs.fileInput.click()"
                                class="group cursor-pointer py-8 border-2 border-dashed border-white/5 rounded-2xl flex flex-col items-center justify-center gap-3 hover:border-emerald-500/40 hover:bg-emerald-500/[0.02] transition-all bg-zinc-900/20">

                                <div
                                    class="w-12 h-12 rounded-full bg-zinc-900 flex items-center justify-center text-zinc-500 group-hover:text-emerald-500 group-hover:scale-110 transition-all border border-white/5 shadow-inner">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2.5"
                                        viewBox="0 0 24 24">
                                        <path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>

                                <div class="text-center">
                                    <span
                                        class="block text-[10px] font-black text-zinc-400 group-hover:text-emerald-400 uppercase tracking-[0.2em]"
                                        x-text="fileName ? 'SELECTED: ' + fileName : 'CLICK TO SELECT PDF'">
                                    </span>
                                    <span class="text-[9px] text-zinc-600 font-bold uppercase mt-1 block">MAX SIZE:
                                        2MB</span>
                                </div>
                            </div>

                            {{-- Submit Button (Visible only when file is selected) --}}
                            <button type="submit" x-show="fileName" x-transition
                                class="w-full mt-4 py-4 bg-emerald-500 text-zinc-950 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-500/10 hover:bg-emerald-400 transition-all">
                                CONFIRM & UPLOAD NOW
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Right Column: Price Timeline --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="ot-card">
                        <div class="flex items-center justify-between mb-10">
                            <div>
                                <h2 class="text-2xl font-black text-white tracking-tight">PRICE HISTORY</h2>
                                <p class="text-zinc-500 text-[10px] font-bold uppercase tracking-widest mt-1">Verified
                                    Market Records</p>
                            </div>
                            <div class="px-4 py-2 bg-emerald-500/5 border border-emerald-500/10 rounded-xl">
                                <span class="text-[10px] font-black text-emerald-500 tracking-widest uppercase">Latest
                                    Updates</span>
                            </div>
                        </div>

                        <div class="space-y-6 relative">
                            <div
                                class="timeline-line absolute left-6 top-2 bottom-2 w-px bg-gradient-to-b from-emerald-500/50 via-white/5 to-transparent">
                            </div>

                            @foreach($market->prices as $price)
                                <div class="price-history-item relative pl-14 group/item">
                                    <div
                                        class="timeline-dot absolute left-[21px] top-4 w-2.5 h-2.5 rounded-full bg-zinc-900 border-2 border-emerald-500 shadow-[0_0_10px_rgba(16,185,129,0.3)]">
                                    </div>
                                    <div
                                        class="p-6 bg-zinc-950/30 border border-white/5 rounded-[2rem] flex flex-col md:flex-row justify-between items-start md:items-center gap-4 hover:border-emerald-500/20 hover:bg-zinc-950/60 transition-all">
                                        <div>
                                            <div
                                                class="text-[10px] font-mono font-bold text-zinc-500 uppercase tracking-widest mb-1">
                                                {{ $price->created_at->format('d M, Y — h:i A') }}
                                            </div>
                                            <div class="text-4xl font-black text-white tracking-tighter">
                                                ৳{{ number_format($price->price, 2) }}</div>
                                        </div>
                                        <div
                                            class="px-4 py-1.5 rounded-lg bg-emerald-500/5 text-emerald-500 text-[10px] font-black border border-emerald-500/10 uppercase tracking-widest">
                                            Verified
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Danger Zone --}}
                    <div class="ot-card border-rose-500/10 bg-rose-500/[0.02]">
                        <div class="ot-label text-rose-500 mb-4 tracking-[0.3em]">DANGER ZONE</div>
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                            <p class="text-xs text-zinc-500 font-medium">এই বাজারটি ডিলিট করলে এর সাথে সম্পর্কিত সকল ডাটা
                                এবং ফাইল স্থায়ীভাবে মুছে যাবে।</p>
                            <form action="{{ route('markets.destroy', $market->id) }}" method="POST"
                                onsubmit="return confirm('আপনি কি নিশ্চিত?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-3 bg-rose-500/10 text-rose-500 rounded-xl font-bold text-[10px] border border-rose-500/20 hover:bg-rose-500 hover:text-white transition-all uppercase tracking-widest">
                                    DELETE MARKET
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
