<?php

namespace YourVendor\FakeInbox\Services;

use YourVendor\FakeInbox\Contracts\InboxServiceInterface;
use YourVendor\FakeInbox\Exceptions\InvalidInboxException;
use YourVendor\FakeInbox\Models\Inbox;
use Illuminate\Support\Facades\Auth;

/**
 * Main service for managing fake inbox functionality.
 */
class FakeInboxManager implements InboxServiceInterface
{
    private ?Inbox $currentInbox = null;
    private bool $enabled = false;

    /**
     * {@inheritDoc}
     */
    public function enable(): void
    {
        $this->enabled = true;
        config(['mail.default' => 'fake-inbox']);
    }

    /**
     * {@inheritDoc}
     */
    public function disable(): void
    {
        $this->enabled = false;
        config(['mail.default' => config('fake-inbox.fallback_mailer', 'smtp')]);
    }

    /**
     * {@inheritDoc}
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentInbox(): Inbox
    {
        return $this->currentInbox ?? $this->getDefaultInbox();
    }

    /**
     * {@inheritDoc}
     */
    public function setCurrentInbox(Inbox $inbox): void
    {
        if ($inbox->user_id !== Auth::id()) {
            throw new InvalidInboxException('Inbox does not belong to current user');
        }

        $this->currentInbox = $inbox;
    }

    /**
     * Get the default inbox for current user.
     *
     * @return Inbox
     */
    private function getDefaultInbox(): Inbox
    {
        return Inbox::firstOrCreate(
            ['user_id' => Auth::id(), 'slug' => 'default'],
            ['name' => 'Default Inbox', 'settings' => []]
        );
    }
}