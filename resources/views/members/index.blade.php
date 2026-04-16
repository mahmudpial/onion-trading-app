@extends('layouts.app')

@section('title', 'সদস্য')
@section('page-title', '👥 সদস্য তালিকা')

@section('topbar-actions')
    <button onclick="toggleModal('memberModal')" class="ot-btn-primary group">
        <svg class="group-hover:rotate-90 transition-transform" width="16" height="16" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="3" stroke-linecap="round">
            <line x1="12" y1="5" x2="12" y2="19" />
            <line x1="5" y1="12" x2="19" y2="12" />
        </svg>
        <span>নতুন সদস্য</span>
    </button>
@endsection

@push('styles')
    <style>
        :root {
            --bg0: #050a06;
            --bg1: #0c1410;
            --bg2: #121d16;
            --b0: rgba(16, 185, 129, 0.08);
            --b1: rgba(16, 185, 129, 0.2);
            --tx0: #f4f4f5;
            --g0: #10b981;
        }

        .ot-wrap {
            background: var(--bg0);
            min-height: 100vh;
            padding: 2px;
            position: relative;
            font-family: 'Hind Siliguri', sans-serif;
            color: var(--tx0);
        }

        .ot-card {
            background: var(--bg1);
            border: 1px solid var(--b0);
            border-radius: 32px;
            backdrop-filter: blur(12px);
            transition: all 0.4s;
            position: relative;
            overflow: hidden;
        }

        .ot-card:hover {
            border-color: var(--b1);
            transform: translateY(-4px);
            background: var(--bg2);
        }

        .ot-input {
            background: #040805 !important;
            border: 1px solid var(--b0) !important;
            border-radius: 16px !important;
            color: var(--tx0) !important;
            font-size: 14px !important;
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
            border: none;
            cursor: pointer;
            box-shadow: 0 10px 20px -10px rgba(16, 185, 129, 0.4);
        }

        .font-data {
            font-family: 'JetBrains Mono', monospace;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(16, 185, 129, 0.1);
            color: var(--g0);
        }

        @media (max-width: 768px) {
            .ot-wrap {
                padding: 10px;
            }

            .ot-card {
                border-radius: 20px;
            }

            .ot-btn-primary {
                width: 100%;
                justify-content: center;
            }

            .stat-icon {
                width: 40px;
                height: 40px;
                border-radius: 12px;
            }

            #memberModal .ot-card {
                padding: 20px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="ot-wrap">
        <div class="max-w-7xl mx-auto relative z-10 space-y-8">

            {{-- ১. স্ট্যাট কার্ডস --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="ot-card p-6 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-data font-bold text-zinc-500 uppercase tracking-widest">Total Agents</p>
                        <h3 class="text-3xl font-black text-white mt-1 font-data">{{ $members->total() }}</h3>
                    </div>
                    <div class="stat-icon text-xl">👥</div>
                </div>
                <div class="ot-card p-6 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-data font-bold text-zinc-500 uppercase tracking-widest">Active Markets
                        </p>
                        <h3 class="text-3xl font-black text-white mt-1 font-data">{{ $active_markets_count ?? '0' }}</h3>
                    </div>
                    <div class="stat-icon text-xl">🏪</div>
                </div>
                <div class="ot-card p-6 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-data font-bold text-zinc-500 uppercase tracking-widest">System Status</p>
                        <h3 class="text-3xl font-black text-emerald-400 mt-1 font-data">Online</h3>
                    </div>
                    <div class="stat-icon text-xl">⚡</div>
                </div>
            </div>

            {{-- ২. সার্চ এরিয়া --}}
            <div class="ot-card p-4">
                <form action="{{ route('members.index') }}" method="GET" class="flex flex-wrap lg:flex-nowrap gap-4">
                    <div class="relative flex-1 min-w-[280px]">
                        <input type="text" name="search" value="{{ $search }}" placeholder="নাম বা ফোন দিয়ে খুঁজুন..."
                            class="ot-input w-full pl-6 pr-5 py-4 font-data">
                    </div>
                    <button type="submit"
                        class="px-8 py-4 bg-zinc-800 hover:bg-zinc-700 border border-zinc-700 rounded-2xl text-sm font-black text-white transition-all">Search</button>
                </form>
            </div>

            {{-- ৩. মেম্বার গ্রিড --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($members as $member)
                    <div class="ot-card group p-8">
                        <div class="flex items-start gap-5">
                            <div
                                class="w-16 h-16 rounded-[22px] bg-zinc-950 border border-white/5 flex items-center justify-center text-2xl font-black text-emerald-500 group-hover:border-emerald-500/30 transition-all font-data">
                                {{ substr($member->name, 0, 1) }}
                            </div>
                            <div class="flex-1 pt-1">
                                <h3 class="font-extrabold text-white text-xl tracking-tight group-hover:text-emerald-400">
                                    {{ $member->name }}
                                </h3>
                                <p class="text-[11px] font-data font-bold text-zinc-600 mt-1 uppercase tracking-widest">
                                    {{ $member->phone }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-8 space-y-4">
                            <div
                                class="p-4 rounded-2xl bg-zinc-950/50 border border-white/5 group-hover:bg-zinc-950 transition-colors">
                                <div class="text-[9px] font-data font-bold text-zinc-700 uppercase tracking-widest mb-2">
                                    Assigned Market</div>
                                <div class="flex items-center gap-3">
                                    <span class="text-lg">🏪</span>
                                    <span
                                        class="text-sm font-bold text-zinc-300">{{ $member->market->name ?? 'Not Assigned' }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <a href="tel:{{ $member->phone }}"
                                    class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl text-emerald-400 font-black text-xs hover:bg-emerald-500 hover:text-zinc-950 transition-all">
                                    কল দিন
                                </a>
                                <a href="{{ route('members.edit', $member) }}"
                                    class="w-11 h-11 rounded-xl bg-zinc-950 border border-white/5 flex items-center justify-center text-zinc-600 hover:text-white transition-all">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2.5">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                                <form action="{{ route('members.destroy', $member) }}" method="POST"
                                    onsubmit="return confirm('মুছে ফেলতে চান?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-11 h-11 rounded-xl bg-zinc-950 border border-white/5 flex items-center justify-center text-rose-500/50 hover:text-rose-500 transition-all">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <h3 class="text-zinc-500 font-bold">কোনো সদস্য পাওয়া যায়নি</h3>
                    </div>
                @endforelse
            </div>

            {{-- প্যাজিনেশন --}}
            <div class="mt-8">
                {{ $members->links() }}
            </div>
        </div>
    </div>

    {{-- ৫. মোডাল অংশ --}}
    <div id="memberModal"
        class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4">
        <div class="ot-card w-full max-w-xl p-8 border-emerald-500/20 shadow-2xl animate-in zoom-in-95 duration-200">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-2xl font-black text-white font-display">নতুন সদস্য যুক্ত করুন</h2>
                <button onclick="toggleModal('memberModal')"
                    class="text-zinc-500 hover:text-white text-3xl leading-none">&times;</button>
            </div>

            <form action="{{ route('members.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="text-[10px] font-bold text-zinc-500 uppercase mb-2 block font-data">Full Name</label>
                        <input type="text" name="name" required placeholder="সদস্যের নাম"
                            class="ot-input w-full px-5 py-3.5 focus:ring-0">
                    </div>
                    <div>
                        <label class="text-[10px] font-bold text-zinc-500 uppercase mb-2 block font-data">Phone
                            Number</label>
                        <input type="text" name="phone" required placeholder="017XXXXXXXX"
                            class="ot-input w-full px-5 py-3.5 font-data focus:ring-0">
                    </div>
                </div>

                <div>
                    <label class="text-[10px] font-bold text-zinc-500 uppercase mb-2 block font-data">Assign Market</label>
                    <select name="market_id" required class="ot-input w-full px-5 py-3.5 appearance-none focus:ring-0">
                        <option value="">বাজার সিলেক্ট করুন</option>
                        @forelse($markets as $market)
                            <option value="{{ $market->id }}">{{ $market->name }} ({{ $market->division }})</option>
                        @empty
                            <option disabled>কোনো বাজার পাওয়া যায়নি</option>
                        @endforelse
                    </select>
                </div>

                <button type="submit"
                    class="w-full bg-emerald-500 text-black font-black py-4 rounded-2xl hover:bg-emerald-400 transition-all shadow-lg shadow-emerald-500/20">
                    মেম্বার প্রোফাইল তৈরি করুন
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            modal.classList.toggle('hidden');
        }

        // এস্কেপ কি চাপলে মোডাল বন্ধ হবে
        window.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.getElementById('memberModal').classList.add('hidden');
            }
        });
    </script>
@endsection
