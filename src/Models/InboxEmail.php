<?php

namespace YourVendor\FakeInbox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InboxEmail extends Model
{
    protected $fillable = [
        'message_id', 'subject', 'from', 'to', 'cc', 'bcc', 'reply_to',
        'html_body', 'text_body', 'raw_body', 'headers', 'is_read', 'is_spam',
        'spam_score', 'spam_details', 'forwarded_to'
    ];

    protected $casts = [
        'from' => 'array',
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'reply_to' => 'array',
        'spam_details' => 'array',
    ];

    public function inbox(): BelongsTo
    {
        return $this->belongsTo(Inbox::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(InboxAttachment::class);
    }

    public function markAsRead(): void
    {
        $this->update(['is_read' => true]);
    }
}