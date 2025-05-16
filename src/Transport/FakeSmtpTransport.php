<?php

namespace YourVendor\FakeInbox\Transport;

use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\MessageConverter;
use YourVendor\FakeInbox\Models\Inbox;
use YourVendor\FakeInbox\Models\InboxEmail;
use YourVendor\FakeInbox\Services\EmailProcessing\AttachmentProcessor;
use YourVendor\FakeInbox\Services\EmailProcessing\EmailSanitizer;

/**
 * Fake SMTP transport that intercepts emails for testing.
 */
class FakeSmtpTransport extends AbstractTransport
{
    public function __construct(
        private Inbox $inbox,
        private EmailSanitizer $sanitizer,
        private AttachmentProcessor $attachmentProcessor
    ) {
        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        $inboxEmail = $this->storeEmail($email);
        $this->processAttachments($email, $inboxEmail);
    }

    private function storeEmail(Email $email): InboxEmail
    {
        return $this->inbox->emails()->create([
            'message_id' => $email->getHeaders()->get('Message-ID')?->getId() ?? $this->generateMessageId(),
            'subject' => $email->getSubject(),
            'from' => $this->formatAddresses($email->getFrom()),
            'to' => $this->formatAddresses($email->getTo()),
            'cc' => $this->formatAddresses($email->getCc()),
            'bcc' => $this->formatAddresses($email->getBcc()),
            'reply_to' => $this->formatAddresses($email->getReplyTo()),
            'html_body' => $this->sanitizer->sanitizeHtml($email->getHtmlBody()),
            'text_body' => $email->getTextBody(),
            'raw_body' => $email->toString(),
            'headers' => $email->getHeaders()->toString(),
        ]);
    }

    private function processAttachments(Email $email, InboxEmail $inboxEmail): void
    {
        $this->attachmentProcessor->process($email, $inboxEmail);
    }

    private function formatAddresses(array $addresses): array
    {
        return array_map(fn (Address $address) => [
            'email' => $address->getAddress(),
            'name' => $address->getName(),
        ], $addresses);
    }

    private function generateMessageId(): string
    {
        return bin2hex(random_bytes(16)).'@fake-inbox';
    }

    /**
     * {@inheritDoc}
     */
    public function __toString(): string
    {
        return 'fake-inbox';
    }
}