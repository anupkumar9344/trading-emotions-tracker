<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('trade_date'); // For daily tracking
            $table->integer('trade_number'); // 1, 2, or 3 for the day
            $table->enum('status', ['pre_trade', 'in_trade', 'completed', 'cancelled'])->default('pre_trade');
            $table->timestamps();
            
            // Ensure only 3 trades per day per user
            $table->unique(['user_id', 'trade_date', 'trade_number']);
            $table->index(['user_id', 'trade_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
