<?php

use Illuminate\Support\Facades\Route;
use YourVendor\FakeInbox\Http\Controllers\Api\InboxApiController;
use YourVendor\FakeInbox\Http\Controllers\Api\InboxEmailApiController;

Route::group([
    'prefix' => config('fake-inbox.api.route_prefix'),
    'middleware' => config('fake-inbox.api.middleware'),
], function () {
    // Inbox API Endpoints
    Route::get('/inboxes', [InboxApiController::class, 'index']);
    Route::post('/inboxes', [InboxApiController::class, 'store']);
    Route::get('/inboxes/{inbox}', [InboxApiController::class, 'show']);
    
    // Email API Endpoints
    Route::get('/inboxes/{inbox}/emails', [InboxEmailApiController::class, 'index']);
    Route::get('/inboxes/{inbox}/emails/{email}', [InboxEmailApiController::class, 'show']);
    Route::post('/inboxes/{inbox}/emails/{email}/forward', [InboxEmailApiController::class, 'forward']);
});