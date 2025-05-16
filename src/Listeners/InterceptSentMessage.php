<?php

namespace YourVendor\FakeInbox\Listeners;

use Illuminate\Mail\Events\MessageSending;
use YourVendor\FakeInbox\Facades\FakeInbox;
use YourVendor\FakeInbox\Transport\FakeSmtpTransport;

/**
 * Listener to intercept sent messages when fake inbox is enabled
 */
class InterceptSentMessage
{
    /**
     * Handle the event
     *
     * @param MessageSending $event
     * @return void
     */
    public function handle(MessageSending $event)
    {
        if (FakeInbox::isEnabled()) {
            $event->message->setSymfonyTransport(
                new FakeSmtpTransport(
                    FakeInbox::getCurrentInbox(),
                    app(\YourVendor\FakeInbox\Services\EmailProcessing\EmailSanitizer::class),
                    app(\YourVendor\FakeInbox\Services\EmailProcessing\AttachmentProcessor::class)
                )
            );
        }
    }
}