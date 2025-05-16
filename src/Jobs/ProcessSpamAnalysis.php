<?php

namespace YourVendor\FakeInbox\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use YourVendor\FakeInbox\Models\InboxEmail;

/**
 * Job to process spam analysis on an email
 */
class ProcessSpamAnalysis implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public InboxEmail $email
    ) {}

    public function handle()
    {
        $this->email->analyzeForSpam(
            app(\YourVendor\FakeInbox\Contracts\SpamAnalyzerInterface::class)
        );
    }
}