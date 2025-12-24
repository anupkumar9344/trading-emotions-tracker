@extends('trades.layout')

@section('title', 'Trade History')

@section('content')
<div class="px-4 sm:px-0">
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Trade History</h1>
        
        @if($trades->isEmpty())
            <p class="text-gray-600 dark:text-gray-400">No completed trades yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Trade #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Market Condition</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Result</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Confidence Impact</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($trades as $trade)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ \Carbon\Carbon::parse($trade->trade_date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    #{{ $trade->trade_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if($trade->checklist)
                                        {{ ucfirst(str_replace('_', ' ', $trade->checklist->market_condition)) }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($trade->review)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($trade->review->result === 'win') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                            @elseif($trade->review->result === 'loss') bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300
                                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300
                                            @endif">
                                            {{ ucfirst($trade->review->result) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    @if($trade->review && $trade->review->confidence_impact)
                                        <span class="capitalize">{{ $trade->review->confidence_impact }}</span>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="showTradeDetails({{ $trade->id }})" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        View Details
                                    </button>
                                </td>
                            </tr>
                            
                            <!-- Trade Details Modal (hidden by default) -->
                            <tr id="details-{{ $trade->id }}" class="hidden">
                                <td colspan="6" class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                                    <div class="space-y-4">
                                        @if($trade->checklist)
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Pre-Trade Checklist</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400"><strong>Trade Reason:</strong> {{ $trade->checklist->trade_reason }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    Confidence: {{ $trade->checklist->confidence_level }}/5 | 
                                                    Stress: {{ $trade->checklist->stress_level }}/5 | 
                                                    Patience: {{ $trade->checklist->patience_level }}/5
                                                </p>
                                            </div>
                                        @endif
                                        
                                        @if($trade->emotion)
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">In-Trade Emotions</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    Feeling: {{ ucfirst($trade->emotion->feeling_after_entry) }} | 
                                                    Stuck to Plan: {{ ucfirst(str_replace('_', ' ', $trade->emotion->stuck_to_plan)) }}
                                                </p>
                                            </div>
                                        @endif
                                        
                                        @if($trade->review)
                                            <div>
                                                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Post-Trade Review</h4>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    Satisfaction: {{ $trade->review->satisfaction_level }}/5 | 
                                                    Frustration: {{ $trade->review->frustration_level }}/5
                                                </p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><strong>Lessons Learned:</strong> {{ $trade->review->lessons_learned }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><strong>Next Time:</strong> {{ $trade->review->next_time_different }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $trades->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function showTradeDetails(tradeId) {
    const detailsRow = document.getElementById('details-' + tradeId);
    if (detailsRow.classList.contains('hidden')) {
        detailsRow.classList.remove('hidden');
    } else {
        detailsRow.classList.add('hidden');
    }
}
</script>
@endsection

