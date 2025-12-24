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
        Schema::create('trade_emotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_id')->constrained()->onDelete('cascade');
            
            // How do I feel after entering?
            $table->enum('feeling_after_entry', ['confident', 'uncertain', 'regretful', 'excited', 'anxious'])->nullable();
            
            // Did I stick to my plan?
            $table->enum('stuck_to_plan', ['yes_fully', 'no_hesitated_entry', 'no_entered_early_late'])->nullable();
            
            // Did I consider closing early out of fear?
            $table->boolean('considered_closing_early')->nullable();
            
            // What emotions am I feeling now?
            $table->boolean('feeling_fear')->nullable();
            $table->boolean('feeling_greed')->nullable();
            $table->boolean('feeling_overconfidence')->nullable();
            $table->boolean('feeling_panic')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_emotions');
    }
};
