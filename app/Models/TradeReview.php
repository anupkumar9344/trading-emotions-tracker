<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeReview extends Model
{
    protected $fillable = [
        'trade_id',
        'result',
        'followed_plan_100',
        'took_profits_too_early',
        'moved_stop_loss_emotionally',
        'held_losing_trade_too_long',
        'got_out_too_early',
        'satisfaction_level',
        'frustration_level',
        'confidence_impact',
        'lessons_learned',
        'next_time_different',
    ];

    public function trade(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }
}
