<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MarketService;
use App\Models\Market;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function __construct(private MarketService $marketService)
    {
    }

    public function index(Request $request)
    {
        $division = $request->get('division');

        $data = $this->marketService->priceComparison($division);

        return view('compare.index', [
            'markets' => $data['markets'],
            'minPrice' => $data['min_price'],
            'maxPrice' => $data['max_price'],
            'avgPrice' => $data['avg_price'],
            'range' => $data['range'],
            'division' => $division,
            'divisions' => Market::divisions(),
        ]);
    }
}