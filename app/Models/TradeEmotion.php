<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradeEmotion extends Model
{
    protected $fillable = [
        'trade_id',
        'feeling_after_entry',
        'stuck_to_plan',
        'considered_closing_early',
        'feeling_fear',
        'feeling_greed',
        'feeling_overconfidence',
        'feeling_panic',
    ];

    public function trade(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }
}
