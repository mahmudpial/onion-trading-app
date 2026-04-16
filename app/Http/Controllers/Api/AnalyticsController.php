<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Market;
use App\Services\MarketService;
use App\Helpers\StatsHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AnalyticsController extends Controller
{
    public function __construct(private MarketService $marketService)
    {
    }

    public function index(Request $request)
    {
        $days = (int) $request->get('days', 30);
        $markets = Market::active()->orderBy('name')->get();

        // Ensure this name matches your Blade variable exactly
        $selectedMarketId = $request->get('market_id') ?: $markets->first()?->id;

        $trend = $this->marketService->priceTrend($days);
        $trendPrices = collect($trend)->pluck('avg_price')->filter()->values();

        $currentPrice = $trendPrices->last() ?? 0;
        $predictedPrice = $this->calculateForecast($trendPrices, 7);

        $marketPrices = Market::active()
            ->with(['prices' => fn($q) => $q->latest('date')->limit(30)])
            ->get()
            ->map(fn($market) => $this->mapMarketStats($market))
            ->filter(fn($m) => $m['price'] !== null)
            ->sortBy('price')
            ->values();

        return view('analytics.index', [
            'trend' => $trend,
            'marketPrices' => $marketPrices,
            'markets' => $markets,
            'selectedMarketId' => $selectedMarketId, // Matching Blade variable
            'days' => $days,
            'predictedPrice' => $predictedPrice,
            'currentPrice' => $trendPrices->last() ?? 0,
        ]);
    }

    protected function mapMarketStats(Market $market): array
    {
        $prices = $market->prices->pluck('price');
        $stats = StatsHelper::calculateVolatility($prices);

        return [
            'id' => $market->id,
            'name' => $market->name,
            'price' => $prices->first(),
            'division' => $market->division,
            'volatility' => $stats['std_dev'],
            'mean' => $stats['mean'],
            'status' => $stats['std_dev'] > 5 ? 'High Risk' : 'Stable',
            'status_class' => $stats['std_dev'] > 5 ? 'bg-rose-500/10 text-rose-500' : 'bg-emerald-500/10 text-emerald-500',
        ];
    }

    protected function calculateForecast(Collection $prices, int $daysAhead): float
    {
        $n = $prices->count();
        if ($n < 2)
            return $prices->last() ?? 0.0;

        $y = $prices->toArray();
        $x = range(1, $n);

        $sumX = array_sum($x);
        $sumY = array_sum($y);
        $sumXX = 0;
        $sumXY = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumXX += ($x[$i] * $x[$i]);
            $sumXY += ($x[$i] * $y[$i]);
        }

        $denominator = ($n * $sumXX - pow($sumX, 2));
        if ($denominator == 0)
            return (float) end($y);

        $m = ($n * $sumXY - $sumX * $sumY) / $denominator;
        $b = ($sumY - $m * $sumX) / $n;

        return ($m * ($n + $daysAhead)) + $b;
    }

}