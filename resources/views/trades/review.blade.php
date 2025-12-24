@extends('trades.layout')

@section('title', 'Post-Trade Review - Trade #' . $trade->trade_number)

@section('content')
<div class="px-4 sm:px-0">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Post-Trade Review - Trade #{{ $trade->trade_number }}</h1>
        
        @if($trade->checklist)
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pre-Trade Summary</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Market Condition:</strong> {{ ucfirst(str_replace('_', ' ', $trade->checklist->market_condition)) }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Trade Reason:</strong> {{ $trade->checklist->trade_reason }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('trades.complete-review', $trade) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Trade Result -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Trade Result <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-3 gap-4">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="result" value="win" required class="mr-2"
                            {{ old('result', $trade->review?->result) === 'win' ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Win ✓</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="result" value="loss" required class="mr-2"
                            {{ old('result', $trade->review?->result) === 'loss' ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Loss ✖</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="result" value="break_even" required class="mr-2"
                            {{ old('result', $trade->review?->result) === 'break_even' ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Break-even 😊</span>
                    </label>
                </div>
                @error('result')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Final Thoughts on the Trade -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Final Thoughts on the Trade</h3>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="followed_plan_100" value="1" class="mr-2"
                            {{ old('followed_plan_100', $trade->review?->followed_plan_100) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Followed the plan 100%</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="took_profits_too_early" value="1" class="mr-2"
                            {{ old('took_profits_too_early', $trade->review?->took_profits_too_early) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Took profits too early</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="moved_stop_loss_emotionally" value="1" class="mr-2"
                            {{ old('moved_stop_loss_emotionally', $trade->review?->moved_stop_loss_emotionally) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Moved stop-loss emotionally</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="held_losing_trade_too_long" value="1" class="mr-2"
                            {{ old('held_losing_trade_too_long', $trade->review?->held_losing_trade_too_long) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Held a losing trade too long</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="got_out_too_early" value="1" class="mr-2"
                            {{ old('got_out_too_early', $trade->review?->got_out_too_early) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Got out too early before the full move</span>
                    </label>
                </div>
            </div>

            <!-- Emotional State After Trade -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Emotional State After Trade (Rate from 1 to 5)</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Satisfaction Level</label>
                        <select name="satisfaction_level" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                            <option value="">Select...</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('satisfaction_level', $trade->review?->satisfaction_level) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Frustration Level</label>
                        <select name="frustration_level" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                            <option value="">Select...</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('frustration_level', $trade->review?->frustration_level) == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confidence Boosted or Damaged?</label>
                        <select name="confidence_impact" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                            <option value="">Select...</option>
                            <option value="boosted" {{ old('confidence_impact', $trade->review?->confidence_impact) === 'boosted' ? 'selected' : '' }}>Boosted</option>
                            <option value="damaged" {{ old('confidence_impact', $trade->review?->confidence_impact) === 'damaged' ? 'selected' : '' }}>Damaged</option>
                            <option value="neutral" {{ old('confidence_impact', $trade->review?->confidence_impact) === 'neutral' ? 'selected' : '' }}>Neutral</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Lessons Learned -->
            <div class="border-t pt-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Lessons Learned from This Trade <span class="text-red-500">*</span>
                </label>
                <textarea name="lessons_learned" rows="4" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white" placeholder="Write 1-2 sentences...">{{ old('lessons_learned', $trade->review?->lessons_learned) }}</textarea>
                @error('lessons_learned')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- What Will I Do Differently Next Time? -->
            <div class="border-t pt-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    What Will I Do Differently Next Time? <span class="text-red-500">*</span>
                </label>
                <textarea name="next_time_different" rows="4" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white" placeholder="Write 1-2 sentences...">{{ old('next_time_different', $trade->review?->next_time_different) }}</textarea>
                @error('next_time_different')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('trades.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                    Complete Trade
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

