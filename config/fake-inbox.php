<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    |
    | Configure the default behavior of the fake inbox.
    */
    'default' => [
        'enabled' => env('FAKE_INBOX_ENABLED', false),
        'driver' => 'fake-inbox',
        'fallback_mailer' => env('MAIL_MAILER', 'smtp'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Inbox Settings
    |--------------------------------------------------------------------------
    */
    'inboxes' => [
        'default' => [
            'name' => 'Default Inbox',
            'slug' => 'default',
            'forwarding_enabled' => false,
            'max_emails' => 1000,
            'retention_days' => 30,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Spam Analysis
    |--------------------------------------------------------------------------
    */
    'spam' => [
        'enabled' => true,
        'threshold' => 5.0,
        'rules_path' => storage_path('app/fake-inbox/spam-rules.json'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Security Restrictions
    |--------------------------------------------------------------------------
    |
    | Configure Gmail-like security restrictions for displayed emails.
    */
    'security' => [
        'blocked_extensions' => ['exe', 'bat', 'js', 'vbs', 'jar', 'msi', 'dll'],
        'sanitize_html' => true,
        'allow_svg' => false,
        'allow_scripts' => false,
        'allow_iframes' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | UI Settings
    |--------------------------------------------------------------------------
    */
    'ui' => [
        'route_prefix' => '_fake-inbox',
        'middleware' => ['web', 'auth'],
        'items_per_page' => 20,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Settings
    |--------------------------------------------------------------------------
    */
    'api' => [
        'enabled' => true,
        'route_prefix' => 'api/fake-inbox',
        'middleware' => ['api', 'auth:api'],
        'rate_limit' => '60,1',
    ],
];