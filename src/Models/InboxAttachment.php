<?php

namespace YourVendor\FakeInbox\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InboxAttachment extends Model
{
    protected $fillable = [
        'original_name', 'storage_path', 'mime_type', 'size'
    ];

    public function email(): BelongsTo
    {
        return $this->belongsTo(InboxEmail::class);
    }
}