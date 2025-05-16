<?php

namespace YourVendor\FakeInbox\Console\Commands;

use Illuminate\Console\Command;

/**
 * Command to install the fake inbox package
 */
class InstallCommand extends Command
{
    protected $signature = 'fake-inbox:install';
    protected $description = 'Install the Fake Inbox package';

    public function handle()
    {
        $this->info('Publishing configuration...');
        $this->call('vendor:publish', [
            '--provider' => 'YourVendor\FakeInbox\FakeInboxServiceProvider',
            '--tag' => 'fake-inbox-config'
        ]);

        $this->info('Running migrations...');
        $this->call('migrate');

        $this->info('Fake Inbox installed successfully!');
        return 0;
    }
}