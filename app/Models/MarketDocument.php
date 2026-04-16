<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MarketDocument extends Model
{
    protected $fillable = [
        'market_id',
        'file_name',
        'file_path'
    ];

    /**
     * ডক্যুমেন্টটি কোন বাজারের সেটি নির্দেশ করে
     */
    public function market()
    {
        return $this->belongsTo(Market::class);
    }

    /**
     * ফাইলের পুরো ইউআরএল পাওয়ার জন্য একটি Accessor
     * এটি ব্যবহার করলে ব্লেড ফাইলে সরাসরি $doc->file_url লিখতে পারবেন
     */
    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}