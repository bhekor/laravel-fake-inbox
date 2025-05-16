<?php

namespace YourVendor\FakeInbox;

use Illuminate\Mail\MailManager;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use YourVendor\FakeInbox\Contracts\InboxServiceInterface;
use YourVendor\FakeInbox\Contracts\SpamAnalyzerInterface;
use YourVendor\FakeInbox\Listeners\InterceptSentMessage;
use YourVendor\FakeInbox\Services\FakeInboxManager;
use YourVendor\FakeInbox\Services\SpamAnalysis\SpamAnalyzer;
use YourVendor\FakeInbox\Transport\FakeSmtpTransport;

/**
 * Service provider for the Laravel Fake Inbox package.
 */
class FakeInboxServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/fake-inbox.php', 'fake-inbox');

        $this->app->singleton(InboxServiceInterface::class, FakeInboxManager::class);
        $this->app->singleton(SpamAnalyzerInterface::class, function ($app) {
            return new SpamAnalyzer(config('fake-inbox.spam'));
        });

        $this->app->afterResolving(MailManager::class, function (MailManager $manager) {
            $manager->extend('fake-inbox', function () {
                return new FakeSmtpTransport(
                    $this->app->make(InboxServiceInterface::class)->getCurrentInbox(),
                    $this->app->make(\YourVendor\FakeInbox\Services\EmailProcessing\EmailSanitizer::class),
                    $this->app->make(\YourVendor\FakeInbox\Services\EmailProcessing\AttachmentProcessor::class)
                );
            });
        });
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'fake-inbox');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/fake-inbox.php' => config_path('fake-inbox.php'),
            ], 'fake-inbox-config');
        }

        Event::listen(\Illuminate\Mail\Events\MessageSending::class, InterceptSentMessage::class);
    }
}