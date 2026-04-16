<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'market_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Relationships ───────────────────────────────────────────

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }

    // ─── Accessors ───────────────────────────────────────────────

    /**
     * Return formatted phone with tel: link ready string.
     */
    public function getTelLinkAttribute(): string
    {
        return 'tel:' . preg_replace('/\D/', '', $this->phone);
    }

    /**
     * First letter of name for avatar.
     */
    public function getInitialAttribute(): string
    {
        return mb_strtoupper(mb_substr($this->name, 0, 1));
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}