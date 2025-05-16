<?php

namespace YourVendor\FakeInbox\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use YourVendor\FakeInbox\Exceptions\EmailForwardingException;
use YourVendor\FakeInbox\Mail\ForwardedEmailMessage;
use YourVendor\FakeInbox\Models\InboxEmail;

class ForwardEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public InboxEmail $email,
        public string $recipient
    ) {}

    public function handle()
    {
        if (!filter_var($this->recipient, FILTER_VALIDATE_EMAIL)) {
            throw new EmailForwardingException("Invalid recipient email: {$this->recipient}");
        }

        Mail::to($this->recipient)->send(
            new ForwardedEmailMessage($this->email)
        );

        $this->email->update(['forwarded_to' => $this->recipient]);
    }
}