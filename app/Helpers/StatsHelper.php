<?php

namespace App\Helpers;

class StatsHelper
{
    /**
     * Calculate Standard Deviation and Variance from an array of numbers.
     * * @param array|iterable $numbers
     * @param bool $sample Set to true if calculating for a sample (N-1) rather than population (N)
     * @return array ['mean', 'variance', 'std_dev']
     */
    public static function calculateVolatility(iterable $numbers, bool $sample = false): array
    {
        $collection = collect($numbers)->filter(fn($n) => is_numeric($n));
        $n = $collection->count();

        if ($n < 2) {
            return ['mean' => $collection->first() ?? 0, 'variance' => 0, 'std_dev' => 0];
        }

        $mean = $collection->avg();

        // 1. Calculate sum of squared differences: Σ(x - μ)²
        $sumOfSquares = $collection->reduce(function ($carry, $item) use ($mean) {
            return $carry + pow($item - $mean, 2);
        }, 0);

        // 2. Variance: Divide by N (Population) or N-1 (Sample)
        $divisor = $sample ? $n - 1 : $n;
        $variance = $sumOfSquares / $divisor;

        // 3. Standard Deviation: Square root of variance
        $stdDev = sqrt($variance);

        return [
            'mean' => round($mean, 2),
            'variance' => round($variance, 2),
            'std_dev' => round($stdDev, 2),
        ];
    }
}