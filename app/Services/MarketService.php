<?php

namespace App\Services;

use App\Models\Market;
use App\Models\Price;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class MarketService
{
    /**
     * Get all markets with latest price + member, sorted by price asc.
     */
    public function marketsWithLatestPrices(?string $division = null): Collection
    {
        $query = Market::with([
            'member',
            'prices' => function ($q) {
                $q->latest('date')->limit(1);
            }
        ])->active();

        if ($division) {
            $query->byDivision($division);
        }

        return $query->orderBy('name')->get()->map(function (Market $market) {
            $market->latest_price_value = $market->prices->first()?->price;
            return $market;
        });
    }

    /**
     * Get comparison data — markets ranked cheapest to most expensive.
     */
    public function priceComparison(?string $division = null): array
    {
        $markets = $this->marketsWithLatestPrices($division)
            ->filter(fn($m) => $market = $m->latest_price_value !== null)
            ->sortBy('latest_price_value')
            ->values();

        $prices = $markets->pluck('latest_price_value')->filter();
        $minPrice = $prices->min();
        $maxPrice = $prices->max();
        $range = $maxPrice - $minPrice;

        return [
            'markets' => $markets,
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'avg_price' => $prices->avg(),
            'range' => $range,
        ];
    }

    /**
     * Get 7-day price trend (daily average across all markets).
     */
    public function priceTrend(int $days = 7): array
    {
        $from = now()->subDays($days - 1)->startOfDay();

        $rows = DB::table('prices')
            ->join('markets', 'prices.market_id', '=', 'markets.id')
            ->where('markets.is_active', true)
            ->whereNull('markets.deleted_at')
            ->where('prices.date', '>=', $from->toDateString())
            ->select(
                'prices.date',
                DB::raw('ROUND(AVG(prices.price), 2) as avg_price'),
                DB::raw('MIN(prices.price) as min_price'),
                DB::raw('MAX(prices.price) as max_price'),
                DB::raw('COUNT(*) as market_count')
            )
            ->groupBy('prices.date')
            ->orderBy('prices.date')
            ->get();

        // Fill missing days with null
        $result = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $row = $rows->firstWhere('date', $date);
            $result[] = [
                'date' => $date,
                'label' => now()->subDays($i)->format('D'),
                'avg_price' => $row?->avg_price,
                'min_price' => $row?->min_price,
                'max_price' => $row?->max_price,
                'market_count' => $row?->market_count ?? 0,
            ];
        }

        return $result;
    }

    /**
     * Get per-market price history for chart.
     */
    public function marketPriceHistory(int $marketId, int $days = 30): array
    {
        return Price::forMarket($marketId)
            ->where('date', '>=', now()->subDays($days)->toDateString())
            ->orderBy('date')
            ->get()
            ->map(fn($p) => [
                'date' => $p->date->format('Y-m-d'),
                'label' => $p->date->format('d M'),
                'price' => $p->price,
            ])
            ->toArray();
    }

    /**
     * Dashboard summary stats.
     */
    public function dashboardStats(): array
    {
        $latestPrices = Price::latestPerMarket()->pluck('price');

        return [
            'total_markets' => Market::active()->count(),
            'total_members' => \App\Models\Member::active()->count(),
            'total_prices' => Price::count(),
            'min_price' => $latestPrices->min(),
            'max_price' => $latestPrices->max(),
            'avg_price' => round($latestPrices->avg(), 2),
            'best_buy_market' => $this->bestBuyMarket(),
            'best_sell_market' => $this->bestSellMarket(),
        ];
    }

    public function bestBuyMarket(): ?Market
    {
        $price = Price::latestPerMarket()->orderBy('price')->first();
        return $price?->market()->with('member')->first();
    }

    public function bestSellMarket(): ?Market
    {
        $price = Price::latestPerMarket()->orderByDesc('price')->first();
        return $price?->market()->with('member')->first();
    }

    /**
     * গতদিনের তুলনায় দামের পরিবর্তনের হার বের করা।
     */
    public function getMarketVolatility(int $marketId): array
    {
        // সবশেষ ২টি রেকর্ড নেওয়া (আজকের এবং তার আগের দিনের)
        $prices = Price::where('market_id', $marketId)
            ->orderBy('date', 'desc')
            ->limit(2)
            ->get();

        if ($prices->count() < 2) {
            return ['change' => 0, 'direction' => 'stable'];
        }

        $current = $prices[0]->price;
        $previous = $prices[1]->price;

        // ফর্মুলা: ((Current - Previous) / Previous) * 100
        $change = (($current - $previous) / $previous) * 100;

        return [
            'change' => round($change, 1),
            'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'stable'),
            'diff' => $current - $previous
        ];
    }
}