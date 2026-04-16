<div class="ot-card p-6">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
        <h3 class="text-lg font-bold text-white">সক্রিয় বাজারসমূহ</h3>
    </div>

    <div class="space-y-3">
        @foreach($marketList as $market)
            <div
                class="flex items-center justify-between p-3 rounded-2xl bg-zinc-950/50 border border-white/5 hover:border-emerald-500/30 transition-all group">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-zinc-900 flex items-center justify-center text-[10px] font-bold text-emerald-500">
                        {{ substr($market->name, 0, 1) }}
                    </div>
                    <span class="text-sm font-medium text-zinc-300 group-hover:text-white">{{ $market->name }}</span>
                </div>
                {{-- এখানে আজকের সময় অনুযায়ী আপডেট বা ছোট কোনো স্ট্যাটাস দিতে পারেন --}}
                <span class="text-[9px] font-data text-zinc-600 uppercase tracking-tighter">
                    {{ now()->format('h:i A') }}
                </span>
            </div>
        @endforeach
    </div>
</div>