@extends('trades.layout')

@section('title', 'In-Trade Emotions - Trade #' . $trade->trade_number)

@section('content')
<div class="px-4 sm:px-0">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">In-Trade Emotions - Trade #{{ $trade->trade_number }}</h1>
        
        @if($trade->checklist)
            <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Pre-Trade Summary</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Market Condition:</strong> {{ ucfirst(str_replace('_', ' ', $trade->checklist->market_condition)) }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Trade Reason:</strong> {{ $trade->checklist->trade_reason }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('trades.update-emotions', $trade) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- How do I feel after entering? -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    How do I feel after entering? <span class="text-red-500">*</span>
                </label>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @foreach(['confident', 'uncertain', 'regretful', 'excited', 'anxious'] as $feeling)
                        <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                            <input type="radio" name="feeling_after_entry" value="{{ $feeling }}" required class="mr-2" 
                                {{ old('feeling_after_entry', $trade->emotion?->feeling_after_entry) === $feeling ? 'checked' : '' }}>
                            <span class="text-gray-700 dark:text-gray-300 capitalize">{{ $feeling }}</span>
                        </label>
                    @endforeach
                </div>
                @error('feeling_after_entry')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Did I stick to my plan? -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Did I stick to my plan? <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="stuck_to_plan" value="yes_fully" required class="mr-2"
                            {{ old('stuck_to_plan', $trade->emotion?->stuck_to_plan) === 'yes_fully' ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Yes, fully</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="stuck_to_plan" value="no_hesitated_entry" required class="mr-2"
                            {{ old('stuck_to_plan', $trade->emotion?->stuck_to_plan) === 'no_hesitated_entry' ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">No, I hesitated on entry</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="radio" name="stuck_to_plan" value="no_entered_early_late" required class="mr-2"
                            {{ old('stuck_to_plan', $trade->emotion?->stuck_to_plan) === 'no_entered_early_late' ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">No, I entered too early/late</span>
                    </label>
                </div>
                @error('stuck_to_plan')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Did I consider closing early out of fear? -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Did I consider closing early out of fear? <span class="text-red-500">*</span>
                </label>
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="considered_closing_early" value="1" required class="mr-2"
                            {{ old('considered_closing_early', $trade->emotion?->considered_closing_early) == 1 ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Yes</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="considered_closing_early" value="0" required class="mr-2"
                            {{ old('considered_closing_early', $trade->emotion?->considered_closing_early) == 0 ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">No</span>
                    </label>
                </div>
                @error('considered_closing_early')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- What emotions am I feeling now? -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    What emotions am I feeling now?
                </label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="checkbox" name="feeling_fear" value="1" class="mr-2"
                            {{ old('feeling_fear', $trade->emotion?->feeling_fear) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Fear</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="checkbox" name="feeling_greed" value="1" class="mr-2"
                            {{ old('feeling_greed', $trade->emotion?->feeling_greed) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Greed</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="checkbox" name="feeling_overconfidence" value="1" class="mr-2"
                            {{ old('feeling_overconfidence', $trade->emotion?->feeling_overconfidence) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Overconfidence</span>
                    </label>
                    <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                        <input type="checkbox" name="feeling_panic" value="1" class="mr-2"
                            {{ old('feeling_panic', $trade->emotion?->feeling_panic) ? 'checked' : '' }}>
                        <span class="text-gray-700 dark:text-gray-300">Panic</span>
                    </label>
                </div>
            </div>

            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('trades.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                    Back
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md">
                    Continue to Post-Trade Review
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

