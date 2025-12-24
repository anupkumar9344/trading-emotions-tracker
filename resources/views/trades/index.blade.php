@extends('trades.layout')

@section('title', 'Trading Dashboard')

@section('content')
<div class="px-4 sm:px-0">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.trading_dashboard') }}</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.todays_date') }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($today)->format('F d, Y') }}</p>
            </div>
            <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.completed_trades') }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $completedTrades }}/3</p>
            </div>
            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg">
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('messages.remaining_trades') }}</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $remainingTrades }}</p>
            </div>
        </div>

        @if($canStartNewTrade)
            <a href="{{ route('trades.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm">
                {{ __('messages.start_trade') }} #{{ $nextTradeNumber }}
            </a>
        @else
            <div class="bg-yellow-100 dark:bg-yellow-900/20 border border-yellow-400 dark:border-yellow-700 text-yellow-700 dark:text-yellow-300 px-4 py-3 rounded">
                <p class="font-medium">{{ __('messages.daily_limit_reached') }}</p>
                <p class="text-sm">{{ __('messages.daily_limit_message') }}</p>
            </div>
        @endif
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ __('messages.todays_trades') }}</h2>
        
        @if($trades->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">{{ __('messages.no_trades_today') }}</p>
        @else
            <div class="space-y-4">
                @foreach($trades as $trade)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ __('messages.trade_number', ['number' => $trade->trade_number]) }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('messages.status') }}: 
                                    <span class="font-medium capitalize">{{ str_replace('_', ' ', $trade->status) }}</span>
                                </p>
                            </div>
                            <div class="flex space-x-2">
                                @if($trade->status === 'in_trade')
                                    <a href="{{ route('trades.show', $trade) }}" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded">
                                        {{ __('messages.track_emotions') }}
                                    </a>
                                @elseif($trade->status === 'pre_trade')
                                    <a href="{{ route('trades.show', $trade) }}" class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-sm rounded">
                                        {{ __('messages.continue') }}
                                    </a>
                                @else
                                    <span class="px-3 py-1 bg-gray-400 text-white text-sm rounded">
                                        {{ __('messages.completed') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($trade->checklist)
                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                <p><strong>{{ __('messages.market_condition') }}:</strong> {{ ucfirst(str_replace('_', ' ', $trade->checklist->market_condition)) }}</p>
                                <p><strong>{{ __('messages.trade_reason') }}:</strong> {{ Str::limit($trade->checklist->trade_reason, 100) }}</p>
                            </div>
                        @endif
                        
                        @if($trade->review)
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($trade->review->result === 'win') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                    @elseif($trade->review->result === 'loss') bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300
                                    @endif">
                                    {{ ucfirst($trade->review->result) }}
                                </span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

