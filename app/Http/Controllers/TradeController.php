<?php

namespace App\Http\Controllers;

use App\Models\Trade;
use App\Models\TradeChecklist;
use App\Models\TradeEmotion;
use App\Models\TradeReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TradeController extends Controller
{
    const MAX_TRADES_PER_DAY = 3;

    /**
     * Display the dashboard with today's trades
     */
    public function index()
    {
        $today = now()->toDateString();
        $user = Auth::user();
        
        // Get today's trades
        $trades = Trade::where('user_id', $user->id)
            ->where('trade_date', $today)
            ->orderBy('trade_number')
            ->with(['checklist', 'emotion', 'review'])
            ->get();
        
        // Count completed trades today
        $completedTrades = $trades->where('status', 'completed')->count();
        $remainingTrades = self::MAX_TRADES_PER_DAY - $completedTrades;
        
        // Get next trade number
        $nextTradeNumber = $trades->max('trade_number') ? $trades->max('trade_number') + 1 : 1;
        
        return view('trades.index', [
            'trades' => $trades,
            'today' => $today,
            'completedTrades' => $completedTrades,
            'remainingTrades' => $remainingTrades,
            'nextTradeNumber' => $nextTradeNumber,
            'canStartNewTrade' => $completedTrades < self::MAX_TRADES_PER_DAY,
        ]);
    }

    /**
     * Start a new trade (pre-trade checklist)
     */
    public function create()
    {
        $today = now()->toDateString();
        $user = Auth::user();
        
        // Check if user can start a new trade
        $completedTrades = Trade::where('user_id', $user->id)
            ->where('trade_date', $today)
            ->where('status', 'completed')
            ->count();
        
        if ($completedTrades >= self::MAX_TRADES_PER_DAY) {
            return redirect()->route('trades.index')
                ->with('error', 'You have reached the maximum of 3 trades for today.');
        }
        
        // Get next trade number
        $lastTrade = Trade::where('user_id', $user->id)
            ->where('trade_date', $today)
            ->orderBy('trade_number', 'desc')
            ->first();
        
        $nextTradeNumber = $lastTrade ? $lastTrade->trade_number + 1 : 1;
        
        return view('trades.create', [
            'tradeNumber' => $nextTradeNumber,
            'today' => $today,
        ]);
    }

    /**
     * Store pre-trade checklist and create trade
     */
    public function store(Request $request)
    {
        $today = now()->toDateString();
        $user = Auth::user();
        
        // Check if user can start a new trade
        $completedTrades = Trade::where('user_id', $user->id)
            ->where('trade_date', $today)
            ->where('status', 'completed')
            ->count();
        
        if ($completedTrades >= self::MAX_TRADES_PER_DAY) {
            return redirect()->route('trades.index')
                ->with('error', 'You have reached the maximum of 3 trades for today.');
        }
        
        // Get next trade number
        $lastTrade = Trade::where('user_id', $user->id)
            ->where('trade_date', $today)
            ->orderBy('trade_number', 'desc')
            ->first();
        
        $nextTradeNumber = $lastTrade ? $lastTrade->trade_number + 1 : 1;
        
        $validated = $request->validate([
            'market_condition' => 'required|in:trending,ranging,high_volatility,low_volatility',
            'entry_aligned_with_strategy' => 'nullable',
            'checked_multiple_confirmations' => 'nullable',
            'rushing_out_of_fomo' => 'nullable',
            'stop_loss_correctly_placed' => 'nullable',
            'risk_reward_at_least_1_2' => 'nullable',
            'confidence_level' => 'required|integer|min:1|max:5',
            'stress_level' => 'required|integer|min:1|max:5',
            'patience_level' => 'required|integer|min:1|max:5',
            'impulsiveness_level' => 'required|integer|min:1|max:5',
            'trade_reason' => 'required|string|max:500',
        ]);
        
        // Convert checkbox values to boolean
        $validated['entry_aligned_with_strategy'] = $request->has('entry_aligned_with_strategy') ? 1 : 0;
        $validated['checked_multiple_confirmations'] = $request->has('checked_multiple_confirmations') ? 1 : 0;
        // rushing_out_of_fomo: if checked (not rushing) = 0, if unchecked (rushing) = 1
        $validated['rushing_out_of_fomo'] = $request->has('rushing_out_of_fomo') ? 0 : 1;
        $validated['stop_loss_correctly_placed'] = $request->has('stop_loss_correctly_placed') ? 1 : 0;
        $validated['risk_reward_at_least_1_2'] = $request->has('risk_reward_at_least_1_2') ? 1 : 0;
        
        DB::transaction(function () use ($user, $today, $nextTradeNumber, $validated) {
            $trade = Trade::create([
                'user_id' => $user->id,
                'trade_date' => $today,
                'trade_number' => $nextTradeNumber,
                'status' => 'in_trade',
            ]);
            
            TradeChecklist::create([
                'trade_id' => $trade->id,
                ...$validated,
            ]);
        });
        
        return redirect()->route('trades.index')
            ->with('success', 'Trade #' . $nextTradeNumber . ' started successfully!');
    }

    /**
     * Show in-trade emotions form
     */
    public function show(Trade $trade)
    {
        // Check if trade belongs to user
        if ($trade->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('trades.show', [
            'trade' => $trade->load(['checklist', 'emotion']),
        ]);
    }

    /**
     * Update in-trade emotions
     */
    public function updateEmotions(Request $request, Trade $trade)
    {
        // Check if trade belongs to user
        if ($trade->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'feeling_after_entry' => 'required|in:confident,uncertain,regretful,excited,anxious',
            'stuck_to_plan' => 'required|in:yes_fully,no_hesitated_entry,no_entered_early_late',
            'considered_closing_early' => 'required',
            'feeling_fear' => 'nullable',
            'feeling_greed' => 'nullable',
            'feeling_overconfidence' => 'nullable',
            'feeling_panic' => 'nullable',
        ]);
        
        // Convert checkbox values to boolean
        $validated['considered_closing_early'] = $request->input('considered_closing_early') == '1' ? 1 : 0;
        $validated['feeling_fear'] = $request->has('feeling_fear') ? 1 : 0;
        $validated['feeling_greed'] = $request->has('feeling_greed') ? 1 : 0;
        $validated['feeling_overconfidence'] = $request->has('feeling_overconfidence') ? 1 : 0;
        $validated['feeling_panic'] = $request->has('feeling_panic') ? 1 : 0;
        
        TradeEmotion::updateOrCreate(
            ['trade_id' => $trade->id],
            $validated
        );
        
        return redirect()->route('trades.review', $trade)
            ->with('success', 'Emotions recorded. Now complete the post-trade review.');
    }

    /**
     * Show post-trade review form
     */
    public function review(Trade $trade)
    {
        // Check if trade belongs to user
        if ($trade->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('trades.review', [
            'trade' => $trade->load(['checklist', 'emotion', 'review']),
        ]);
    }

    /**
     * Store post-trade review and complete trade
     */
    public function completeReview(Request $request, Trade $trade)
    {
        // Check if trade belongs to user
        if ($trade->user_id !== Auth::id()) {
            abort(403);
        }
        
        $validated = $request->validate([
            'result' => 'required|in:win,loss,break_even',
            'followed_plan_100' => 'nullable',
            'took_profits_too_early' => 'nullable',
            'moved_stop_loss_emotionally' => 'nullable',
            'held_losing_trade_too_long' => 'nullable',
            'got_out_too_early' => 'nullable',
            'satisfaction_level' => 'required|integer|min:1|max:5',
            'frustration_level' => 'required|integer|min:1|max:5',
            'confidence_impact' => 'required|in:boosted,damaged,neutral',
            'lessons_learned' => 'required|string|max:1000',
            'next_time_different' => 'required|string|max:1000',
        ]);
        
        // Convert checkbox values to boolean
        $validated['followed_plan_100'] = $request->has('followed_plan_100') ? 1 : 0;
        $validated['took_profits_too_early'] = $request->has('took_profits_too_early') ? 1 : 0;
        $validated['moved_stop_loss_emotionally'] = $request->has('moved_stop_loss_emotionally') ? 1 : 0;
        $validated['held_losing_trade_too_long'] = $request->has('held_losing_trade_too_long') ? 1 : 0;
        $validated['got_out_too_early'] = $request->has('got_out_too_early') ? 1 : 0;
        
        DB::transaction(function () use ($trade, $validated) {
            TradeReview::updateOrCreate(
                ['trade_id' => $trade->id],
                $validated
            );
            
            $trade->update(['status' => 'completed']);
        });
        
        return redirect()->route('trades.index')
            ->with('success', 'Trade #' . $trade->trade_number . ' completed and reviewed!');
    }

    /**
     * View trade history
     */
    public function history()
    {
        $trades = Trade::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->with(['checklist', 'emotion', 'review'])
            ->orderBy('trade_date', 'desc')
            ->orderBy('trade_number', 'desc')
            ->paginate(20);
        
        return view('trades.history', [
            'trades' => $trades,
        ]);
    }
}
