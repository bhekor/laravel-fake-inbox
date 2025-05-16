<?php

namespace YourVendor\FakeInbox\Console\Commands;

use Illuminate\Console\Command;
use YourVendor\FakeInbox\Models\InboxEmail;

class PurgeOldEmailsCommand extends Command
{
    protected $signature = 'fake-inbox:purge {--days=30 : Number of days to keep emails}';
    protected $description = 'Purge old emails from fake inboxes';

    public function handle()
    {
        $cutoff = now()->subDays($this->option('days'));
        $count = InboxEmail::where('created_at', '<', $cutoff)->delete();

        $this->info("Purged {$count} old emails");
        return 0;
    }
}