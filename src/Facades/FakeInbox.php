<?php

namespace YourVendor\FakeInbox\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void enable()
 * @method static void disable()
 * @method static bool isEnabled()
 * @method static \YourVendor\FakeInbox\Models\Inbox getCurrentInbox()
 * @method static void setCurrentInbox(\YourVendor\FakeInbox\Models\Inbox $inbox)
 *
 * @see \YourVendor\FakeInbox\Services\FakeInboxManager
 */
class FakeInbox extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \YourVendor\FakeInbox\Contracts\InboxServiceInterface::class;
    }
}