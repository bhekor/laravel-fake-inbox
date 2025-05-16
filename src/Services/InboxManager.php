<?php

namespace YourVendor\FakeInbox\Services;

use YourVendor\FakeInbox\Models\Inbox;
use Illuminate\Support\Facades\Auth;

/**
 * Service for managing multiple inboxes
 */
class InboxManager
{
    /**
     * Get all inboxes for current user
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllInboxes(int $perPage = 15)
    {
        return Inbox::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Create a new inbox
     *
     * @param string $name
     * @param array $settings
     * @return Inbox
     */
    public function createInbox(string $name, array $settings = [])
    {
        return Inbox::create([
            'user_id' => Auth::id(),
            'name' => $name,
            'slug' => Inbox::generateSlug($name),
            'settings' => array_merge([
                'forwarding_enabled' => false,
                'max_emails' => 1000,
                'retention_days' => 30,
            ], $settings)
        ]);
    }
}