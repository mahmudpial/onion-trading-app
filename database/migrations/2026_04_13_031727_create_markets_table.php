<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('division');
            $table->json('open_days')->nullable()->comment('JSON array: ["Saturday","Wednesday"]');
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('division');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('markets');
    }
};