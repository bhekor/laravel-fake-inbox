<div class="email-body mt-4">
    @if($email->html_body)
        <div class="prose max-w-none">
            {!! $email->html_body !!}
        </div>
    @else
        <pre class="whitespace-pre-wrap font-sans">{{ $email->text_body }}</pre>
    @endif
</div>