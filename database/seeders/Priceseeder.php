<?php

namespace Database\Seeders;

use App\Models\Market;
use App\Models\Price;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    public function run(): void
    {
        $markets = Market::all();

        // Base prices per market (realistic BDT/KG range for onions)
        $basePrices = [
            'রাজশাহী শাহেব বাজার' => 38,
            'নওগাঁ পুরাতন বাজার' => 36,
            'পাবনা হাট' => 40,
            'সিরাজগঞ্জ বড় বাজার' => 42,
            'নাটোর বনপাড়া হাট' => 37,
            'ঢাকা কাওরান বাজার' => 48,
            'ঢাকা শ্যামবাজার' => 50,
            'খুলনা বড় বাজার' => 45,
            'চট্টগ্রাম খাতুনগঞ্জ' => 47,
        ];

        foreach ($markets as $market) {
            $base = $basePrices[$market->name] ?? 42;

            // Generate 30 days of price data with realistic fluctuation
            for ($daysAgo = 29; $daysAgo >= 0; $daysAgo--) {
                $date = now()->subDays($daysAgo)->format('Y-m-d');

                // Simulate market trend: slight upward pressure over time
                $trend = ($daysAgo / 29) * -3;  // goes from -3 to 0
                $noise = (mt_rand(-50, 50) / 100) * 5;  // ±2.5
                $price = round(max(20, $base + $trend + $noise), 1);

                Price::updateOrCreate(
                    ['market_id' => $market->id, 'date' => $date],
                    ['price' => $price, 'unit' => 'KG']
                );
            }
        }
    }
}