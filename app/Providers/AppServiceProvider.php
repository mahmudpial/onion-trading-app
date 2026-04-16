<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Market;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // স্ট্যাটিক ডেটা শেয়ার করার জন্য ভিউ কম্পোজার ব্যবহার করা হচ্ছে যেমন সক্রিয় বাজারের তালিকা, যা ড্যাশবোর্ড, বাজার তালিকা এবং দাম তালিকায় দরকার হতে পারে.
        // এই কম্পোজারটি নির্দিষ্ট ভিউগুলিতে সক্রিয় বাজারের তালিকা শেয়ার করবে, যেখানে প্রতিটি বাজারের সাথে তার সর্বশেষ দামও থাকবে.
        View::composer(['dashboard.index', 'markets.index', 'prices.index'], function ($view) {
            $view->with('marketList', Market::with([
                'prices' => function ($query) {
                    $query->latest()->limit(1); // প্রতিটি বাজারের শুধু সবশেষ দামটি নেবে
                }
            ])->orderBy('name')->get());
        });
    }
}
