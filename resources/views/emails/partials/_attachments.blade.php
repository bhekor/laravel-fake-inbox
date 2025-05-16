@if($email->attachments->count())
<div class="mt-6 border-t border-gray-200 pt-4">
    <h3 class="font-medium">Attachments ({{ $email->attachments->count() }})</h3>
    <ul class="mt-2 space-y-2">
        @foreach($email->attachments as $attachment)
        <li>
            <a href="{{ route('fake-inbox.emails.attachments.download', [$inbox, $email, $attachment]) }}" 
               class="text-blue-600 hover:underline">
                {{ $attachment->original_name }} ({{ format_bytes($attachment->size) }})
            </a>
        </li>
        @endforeach
    </ul>
</div>
@endif