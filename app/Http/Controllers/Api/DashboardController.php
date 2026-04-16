<?php

namespace App\Http\Controllers\Api; // আপনার প্রজেক্ট অনুযায়ী namespace চেক করে নিন

use App\Http\Controllers\Controller;
use App\Services\MarketService;
use App\Models\Market;
use App\Models\Price;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private MarketService $marketService)
    {
    }

    public function index(Request $request)
    {
        $division = $request->get('division');

        // ১. সার্ভিস থেকে ডাটা নিয়ে আসা
        $markets = $this->marketService->marketsWithLatestPrices($division);
        $priceTrend = $this->marketService->priceTrend(7);

        // ২. ক্যালকুলেশন
        $prices = $markets->pluck('latest_price_value')->filter();

        // ৩. ভিউতে ডাটা পাঠানো
        return view('dashboard.index', [
            'avgPrice' => $prices->isNotEmpty() ? $prices->avg() : 0,
            'marketsCount' => Market::count(),
            'todayRecordsCount' => Price::whereDate('created_at', today())->count(),
            'markets' => $markets,      // মূল লিস্টের জন্য
            'marketList' => Market::all(), // লাইভ টিকার বাবেলের জন্য
            'priceTrend' => $priceTrend,   // চার্টের জন্য
            'minPrice' => $prices->min(),
            'maxPrice' => $prices->max(),
            'division' => $division,
        ]);
    }
}