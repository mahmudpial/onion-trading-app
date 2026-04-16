<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PriceRequest;
use App\Models\Market;
use App\Models\Price;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PriceController extends Controller
{
    public function index(Request $request): View
    {
        $marketId = $request->get('market_id');
        $from = $request->get('from', now()->subDays(30)->toDateString());
        $to = $request->get('to', now()->toDateString());

        $prices = Price::with('market')
            ->forDateRange($from, $to)
            ->when($marketId, fn ($q) => $q->forMarket($marketId))
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('prices.index', [
            'prices' => $prices,
            'markets' => Market::active()->orderBy('name')->get(),
            'marketId' => $marketId,
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function create(): View
    {
        return view('prices.create', [
            'markets' => Market::active()->orderBy('name')->get(),
            'today' => now()->toDateString(),
        ]);
    }

    public function store(PriceRequest $request): RedirectResponse
    {
        // Upsert: if price exists for same market+date, update it
        Price::updateOrCreate(
            [
                'market_id' => $request->market_id,
                'date' => $request->date,
            ],
            [
                'price' => $request->price,
                'unit' => $request->unit ?? 'KG',
                'notes' => $request->notes,
            ]
        );

        return redirect()
            ->route('prices.index')
            ->with('success', 'দাম সফলভাবে রেকর্ড করা হয়েছে! 💰');
    }

    public function edit(Price $price): View
    {
        return view('prices.edit', [
            'price' => $price,
            'markets' => Market::active()->orderBy('name')->get(),
        ]);
    }

    public function update(PriceRequest $request, Price $price): RedirectResponse
    {
        $price->update($request->validated());

        return redirect()
            ->route('prices.index')
            ->with('success', 'দাম আপডেট হয়েছে! ✅');
    }

    public function destroy(Price $price): RedirectResponse
    {
        $price->delete();

        return redirect()
            ->route('prices.index')
            ->with('success', 'দাম মুছে ফেলা হয়েছে।');
    }
}
