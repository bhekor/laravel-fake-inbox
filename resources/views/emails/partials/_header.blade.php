<div class="border-b border-gray-200 pb-4 mb-4">
    <h1 class="text-2xl font-bold">{{ $email->subject }}</h1>
    <div class="flex justify-between mt-2">
        <div>
            <span class="font-medium">From:</span>
            {{ $email->from[0]['name'] ?? $email->from[0]['email'] }}
        </div>
        <div class="text-sm text-gray-500">
            {{ $email->created_at->format('M j, Y g:i A') }}
        </div>
    </div>
    <div class="mt-1">
        <span class="font-medium">To:</span>
        {{ collect($email->to)->map(fn($to) => $to['name'] ?? $to['email'])->join(', ') }}
    </div>
</div>