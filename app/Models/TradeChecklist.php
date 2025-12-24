<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeChecklist extends Model
{
    protected $fillable = [
        'trade_id',
        'market_condition',
        'entry_aligned_with_strategy',
        'checked_multiple_confirmations',
        'rushing_out_of_fomo',
        'stop_loss_correctly_placed',
        'risk_reward_at_least_1_2',
        'confidence_level',
        'stress_level',
        'patience_level',
        'impulsiveness_level',
        'trade_reason',
    ];

    public function trade(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }
}
