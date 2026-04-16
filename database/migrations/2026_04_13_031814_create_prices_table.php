<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('market_id')
                ->constrained('markets')
                ->onDelete('cascade');
            $table->decimal('price', 8, 2)->comment('Price per KG in BDT');
            $table->date('date');
            $table->string('unit', 20)->default('KG')->comment('KG, Maund, 100KG');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['market_id', 'date']);
            $table->index('date');
            // Prevent duplicate price entry for same market + date
            $table->unique(['market_id', 'date'], 'unique_market_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};