<?php

use Illuminate\Support\Facades\Route;
use YourVendor\FakeInbox\Http\Controllers\InboxController;
use YourVendor\FakeInbox\Http\Controllers\InboxEmailController;

Route::group([
    'prefix' => config('fake-inbox.ui.route_prefix'),
    'middleware' => config('fake-inbox.ui.middleware'),
], function () {
    // Inbox Routes
    Route::get('/', [InboxController::class, 'index'])->name('fake-inbox.index');
    Route::get('/inboxes', [InboxController::class, 'index'])->name('fake-inbox.inboxes.index');
    Route::get('/inboxes/create', [InboxController::class, 'create'])->name('fake-inbox.inboxes.create');
    Route::post('/inboxes', [InboxController::class, 'store'])->name('fake-inbox.inboxes.store');
    
    // Email Routes
    Route::get('/inboxes/{inbox}/emails', [InboxEmailController::class, 'index'])->name('fake-inbox.emails.index');
    Route::get('/inboxes/{inbox}/emails/{email}', [InboxEmailController::class, 'show'])->name('fake-inbox.emails.show');
    Route::post('/inboxes/{inbox}/emails/{email}/forward', [InboxEmailController::class, 'forward'])->name('fake-inbox.emails.forward');
});