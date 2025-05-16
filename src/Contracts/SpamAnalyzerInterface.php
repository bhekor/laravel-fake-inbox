<?php

namespace YourVendor\FakeInbox\Contracts;

use YourVendor\FakeInbox\Models\InboxEmail;

/**
 * Interface for spam analysis services
 */
interface SpamAnalyzerInterface
{
    /**
     * Analyze an email for spam content
     *
     * @param InboxEmail $email
     * @return array
     */
    public function analyze(InboxEmail $email): array;
}