<?php

namespace YourVendor\FakeInbox\Services\EmailProcessing;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use YourVendor\FakeInbox\Models\InboxEmail;
use YourVendor\FakeInbox\Models\InboxAttachment;
use Illuminate\Support\Facades\Storage;

/**
 * Service for processing email attachments
 */
class AttachmentProcessor
{
    /**
     * Process attachments from an email
     *
     * @param Email $email
     * @param InboxEmail $inboxEmail
     * @return void
     */
    public function process(Email $email, InboxEmail $inboxEmail): void
    {
        foreach ($email->getAttachments() as $attachment) {
            $this->processAttachment($attachment, $inboxEmail);
        }
    }

    private function processAttachment(DataPart $attachment, InboxEmail $inboxEmail): void
    {
        $path = 'attachments/'.sha1($attachment->getBody()).'.bin';
        Storage::put($path, $attachment->getBody());

        InboxAttachment::create([
            'inbox_email_id' => $inboxEmail->id,
            'original_name' => $attachment->getFilename(),
            'storage_path' => $path,
            'mime_type' => $attachment->getContentType(),
            'size' => strlen($attachment->getBody()),
        ]);
    }
}