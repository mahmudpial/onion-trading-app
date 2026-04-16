<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->json('off_days')->nullable(); // সাপ্তাহিক বন্ধের দিন
            $table->string('opening_time')->nullable(); // যেমন: 08:00 AM
            $table->string('closing_time')->nullable(); // যেমন: 10:00 PM
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            //
        });
    }
};
