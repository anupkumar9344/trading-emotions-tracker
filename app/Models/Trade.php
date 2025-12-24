<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Trade extends Model
{
    protected $fillable = [
        'user_id',
        'trade_date',
        'trade_number',
        'status',
    ];

    protected $casts = [
        'trade_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function checklist(): HasOne
    {
        return $this->hasOne(TradeChecklist::class);
    }

    public function emotion(): HasOne
    {
        return $this->hasOne(TradeEmotion::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(TradeReview::class);
    }
}
