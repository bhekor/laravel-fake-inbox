<?php

namespace YourVendor\FakeInbox\Contracts;

use YourVendor\FakeInbox\Models\Inbox;

/**
 * Interface for the Fake Inbox service
 */
interface InboxServiceInterface
{
    /**
     * Enable email interception
     *
     * @return void
     */
    public function enable(): void;

    /**
     * Disable email interception
     *
     * @return void
     */
    public function disable(): void;

    /**
     * Check if interception is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool;

    /**
     * Get the current active inbox
     *
     * @return Inbox
     */
    public function getCurrentInbox(): Inbox;

    /**
     * Set the current active inbox
     *
     * @param Inbox $inbox
     * @return void
     */
    public function setCurrentInbox(Inbox $inbox): void;
}