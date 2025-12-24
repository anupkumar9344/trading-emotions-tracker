@extends('trades.layout')

@section('title', 'Pre-Trade Checklist - Trade #' . $tradeNumber)

@section('content')
<div class="px-4 sm:px-0">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ __('messages.pre_trade_checklist') }} - {{ __('messages.trade_number', ['number' => $tradeNumber]) }}</h1>
        
        <form method="POST" action="{{ route('trades.store') }}" class="space-y-6">
            @csrf

            <!-- Market Conditions -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('messages.market_conditions') }} <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="market_condition" value="trending" required class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('messages.trending_market') }}</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="market_condition" value="ranging" required class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('messages.ranging_market') }}</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="market_condition" value="high_volatility" required class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('messages.high_volatility') }}</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="market_condition" value="low_volatility" required class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('messages.low_volatility') }}</span>
                    </label>
                </div>
                @error('market_condition')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Trade Setup Confirmation -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('messages.trade_setup_confirmation') }}</h3>
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="checkbox" name="entry_aligned_with_strategy" value="1" required class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('messages.entry_aligned_strategy') }}</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="checked_multiple_confirmations" value="1" required class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('messages.checked_confirmations') }}</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="rushing_out_of_fomo" value="1" required class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('messages.not_rushing_fomo') }}</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="stop_loss_correctly_placed" value="1" required class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('messages.stop_loss_placed') }}</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="risk_reward_at_least_1_2" value="1" required class="mr-2">
                        <span class="text-gray-700 dark:text-gray-300">{{ __('messages.risk_reward_ratio') }}</span>
                    </label>
                </div>
            </div>

            <!-- Emotional State Before Entry -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('messages.emotional_state') }}</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.confidence_level') }}</label>
                        <select name="confidence_level" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.stress_level') }}</label>
                        <select name="stress_level" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.patience_level') }}</label>
                        <select name="patience_level" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('messages.impulsiveness_level') }}</label>
                        <select name="impulsiveness_level" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white">
                            <option value="">{{ __('messages.select_option') }}</option>
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <!-- Why taking this trade -->
            <div class="border-t pt-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('messages.why_taking_trade') }} <span class="text-red-500">*</span>
                </label>
                <textarea name="trade_reason" rows="3" required class="w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm dark:bg-gray-700 dark:text-white" placeholder="{{ __('messages.explain_sentences') }}"></textarea>
                @error('trade_reason')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('trades.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    {{ __('messages.cancel') }}
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    {{ __('messages.start_trade_button') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

