<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Market extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'division',
        'open_days',
        'off_days',      // এটি নিশ্চিত করুন
        'opening_time',  // এটি নিশ্চিত করুন
        'closing_time',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'open_days' => 'array',
        'is_active' => 'boolean',
    ];

    // ─── Relationships ─────────────────────────────────────────

    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class)->orderByDesc('date');
    }

    /**
     * Add the missing documents relationship
     */
    public function documents(): HasMany
    {
        return $this->hasMany(MarketDocument::class);
    }

    // ─── Accessors ──────────────────────────────────────────────

    /**
     * Get the most recent price record.
     */
    public function getLatestPriceAttribute(): ?Price
    {
        return $this->prices->first();
    }

    /**
     * Get the latest price value (numeric).
     */
    public function getLatestPriceValueAttribute(): ?float
    {
        return $this->latestPrice?->price;
    }

    /**
     * Is the market open today?
     */
    public function getIsOpenTodayAttribute(): bool
    {
        $today = now()->setTimezone('Asia/Dhaka')->format('l'); // e.g. "Saturday"
        return in_array($today, $this->open_days ?? []);
    }

    /**
     * Formatted open days as comma string.
     */
    public function getOpenDaysStringAttribute(): string
    {
        return implode(', ', $this->open_days ?? []);
    }

    // ─── Scopes ─────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByDivision($query, string $division)
    {
        return $query->where('division', $division);
    }

    // ─── Static Helpers ─────────────────────────────────────────

    public static function divisions(): array
    {
        return [
            'Dhaka',
            'Rajshahi',
            'Khulna',
            'Chittagong',
            'Sylhet',
            'Barishal',
            'Rangpur',
            'Mymensingh',
        ];
    }

    public static function weekdays(): array
    {
        return ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
    }
}