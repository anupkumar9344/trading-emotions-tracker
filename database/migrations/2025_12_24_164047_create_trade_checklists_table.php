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
        Schema::create('trade_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_id')->constrained()->onDelete('cascade');
            
            // Market Conditions
            $table->enum('market_condition', ['trending', 'ranging', 'high_volatility', 'low_volatility'])->nullable();
            
            // Trade Setup Confirmation
            $table->boolean('entry_aligned_with_strategy')->nullable();
            $table->boolean('checked_multiple_confirmations')->nullable();
            $table->boolean('rushing_out_of_fomo')->nullable();
            $table->boolean('stop_loss_correctly_placed')->nullable();
            $table->boolean('risk_reward_at_least_1_2')->nullable();
            
            // Emotional State Before Entry (1-5 scale)
            $table->integer('confidence_level')->nullable(); // 1-5
            $table->integer('stress_level')->nullable(); // 1-5
            $table->integer('patience_level')->nullable(); // 1-5
            $table->integer('impulsiveness_level')->nullable(); // 1-5
            
            // Why taking this trade
            $table->text('trade_reason')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_checklists');
    }
};
