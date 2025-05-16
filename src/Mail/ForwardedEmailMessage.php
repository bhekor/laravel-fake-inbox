<?php

namespace YourVendor\FakeInbox\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use YourVendor\FakeInbox\Models\InboxEmail;

class ForwardedEmailMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public InboxEmail $email
    ) {}

    public function build()
    {
        return $this->subject("[Forwarded] {$this->email->subject}")
            ->html($this->email->html_body)
            ->text(function() {
                return $this->email->text_body ?: 
                    strip_tags($this->email->html_body);
            });
    }
}