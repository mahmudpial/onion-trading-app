<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends Model
{
    use HasFactory;

    protected $fillable = [
        'market_id',
        'price',
        'date',
        'unit',
        'notes',
    ];

    protected $casts = [
        'price' => 'float',
        'date' => 'date',
    ];

    // ─── Relationships ───────────────────────────────────────────

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    // ─── Accessors ───────────────────────────────────────────────

    public function getFormattedPriceAttribute(): string
    {
        return '৳' . number_format($this->price, 2) . '/' . $this->unit;
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('d M Y');
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeLatestPerMarket($query)
    {
        return $query->whereIn('id', function ($sub) {
            $sub->selectRaw('MAX(id)')
                ->from('prices')
                ->groupBy('market_id');
        });
    }

    public function scopeForDateRange($query, string $from, string $to)
    {
        return $query->whereBetween('date', [$from, $to]);
    }

    public function scopeForMarket($query, int $marketId)
    {
        return $query->where('market_id', $marketId);
    }
}