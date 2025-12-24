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
        Schema::create('trade_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_id')->constrained()->onDelete('cascade');
            
            // Trade Result
            $table->enum('result', ['win', 'loss', 'break_even'])->nullable();
            
            // Final Thoughts on the Trade
            $table->boolean('followed_plan_100')->nullable();
            $table->boolean('took_profits_too_early')->nullable();
            $table->boolean('moved_stop_loss_emotionally')->nullable();
            $table->boolean('held_losing_trade_too_long')->nullable();
            $table->boolean('got_out_too_early')->nullable();
            
            // Emotional State After Trade (1-5 scale)
            $table->integer('satisfaction_level')->nullable(); // 1-5
            $table->integer('frustration_level')->nullable(); // 1-5
            $table->enum('confidence_impact', ['boosted', 'damaged', 'neutral'])->nullable();
            
            // Lessons Learned
            $table->text('lessons_learned')->nullable();
            
            // What will I do differently next time?
            $table->text('next_time_different')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_reviews');
    }
};
