# Laravel Fake Inbox Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/your-vendor/laravel-fake-inbox.svg?style=flat-square)](https://packagist.org/packages/your-vendor/laravel-fake-inbox)
[![Total Downloads](https://img.shields.io/packagist/dt/your-vendor/laravel-fake-inbox.svg?style=flat-square)](https://packagist.org/packages/your-vendor/laravel-fake-inbox)
[![License](https://img.shields.io/github/license/your-vendor/laravel-fake-inbox.svg?style=flat-square)](LICENSE)

A complete fake SMTP server implementation for Laravel that intercepts and stores emails during development and testing, with a Gmail-like interface and REST API.

---

## Features

- 🚀 Intercepts all outgoing emails without sending them  
- 📁 Multiple inboxes for different test scenarios  
- 🔍 Email search and filtering  
- 📤 Email forwarding to real addresses  
- 🛡️ Spam analysis with customizable rules  
- 🔒 Gmail-like security restrictions  
- 💻 Web interface and REST API  
- 🧪 Testing helpers for automated tests  

---

## Installation

Install the package via Composer:

```bash
composer require your-vendor/laravel-fake-inbox --dev
```

Publish the configuration file:

```bash
php artisan vendor:publish --tag=fake-inbox-config
```

Run the database migrations:

```bash
php artisan migrate
```

---

## Configuration

After publishing, you can modify the config in `config/fake-inbox.php`:

```php
return [
    'default' => [
        'enabled' => env('FAKE_INBOX_ENABLED', false),
        'driver' => 'fake-inbox',
        'fallback_mailer' => env('MAIL_MAILER', 'smtp'),
    ],
];
```

Enable in `.env`:

```env
FAKE_INBOX_ENABLED=true
MAIL_MAILER=fake-inbox
```

Or enable programmatically:

```php
use YourVendor\FakeInbox\Facades\FakeInbox;

FakeInbox::enable();
```

---

## Web Interface

Access via:

```
http://your-app.test/_fake-inbox
```

---

## API Endpoints

- `GET /api/fake-inbox/inboxes` – List all inboxes  
- `POST /api/fake-inbox/inboxes` – Create new inbox  
- `GET /api/fake-inbox/inboxes/{inbox}/emails` – List emails in inbox  
- `POST /api/fake-inbox/inboxes/{inbox}/emails/{email}/forward` – Forward email  

---

## Usage in Tests

```php
public function test_email_is_sent()
{
    FakeInbox::enable();

    // Perform action that sends email

    $inbox = FakeInbox::getCurrentInbox();
    $this->assertCount(1, $inbox->emails);

    $email = $inbox->emails->first();
    $this->assertEquals('Test Subject', $email->subject);
}
```

---

## Advanced Features

### Multiple Inboxes

```php
$inbox = FakeInbox::createInbox('My Test Inbox');
FakeInbox::setCurrentInbox($inbox);
```

### Email Forwarding

```php
$email->forward('real@example.com');
```

Or via API:

```http
POST /api/fake-inbox/inboxes/{inbox}/emails/{email}/forward
{
  "recipient": "real@example.com"
}
```

### Spam Analysis

```php
'spam' => [
    'enabled' => true,
    'threshold' => 5.0,
    'rules_path' => storage_path('app/fake-inbox/spam-rules.json'),
],
```

Example rules file (`spam-rules.json`):

```json
{
    "BAYES_99": {
        "score": 3.0,
        "description": "Bayesian spam probability 99%"
    },
    "HTML_MESSAGE": {
        "score": 0.5,
        "description": "HTML included in message"
    }
}
```

### Security Restrictions

```php
'security' => [
    'blocked_extensions' => ['exe', 'bat', 'js', 'vbs', 'jar', 'msi', 'dll'],
    'sanitize_html' => true,
    'allow_svg' => false,
    'allow_scripts' => false,
    'allow_iframes' => false,
],
```

---

## Artisan Commands

- Purge old emails:

```bash
php artisan fake-inbox:purge --days=30
```

- Run installer:

```bash
php artisan fake-inbox:install
```

---

## Testing

Run tests:

```bash
composer test
```

Generate test coverage:

```bash
composer test-coverage
```

---

## Troubleshooting

### Emails not being intercepted

- Ensure `FAKE_INBOX_ENABLED=true` in `.env`
- Check `MAIL_MAILER=fake-inbox`
- Avoid using in production (auto-disabled)

### API/web interface issues

- Check routes are loaded from `routes/api.php` and `routes/web.php`
- Confirm middleware/auth setup
- Validate route prefixes in config

---

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss.

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).