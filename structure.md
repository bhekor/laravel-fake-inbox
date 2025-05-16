laravel-fake-inbox/
├── config/
│   └── fake-inbox.php
├── database/
│   ├── migrations/
│   │   ├── 2023_01_01_000000_create_inboxes_table.php
│   │   ├── 2023_01_01_000001_create_inbox_emails_table.php
│   │   └── 2023_01_01_000002_create_inbox_attachments_table.php
│   └── factories/
│       ├── InboxFactory.php
│       └── InboxEmailFactory.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── emails/
│   │   │   ├── index.blade.php
│   │   │   ├── show.blade.php
│   │   │   └── partials/
│   │   │       ├── _header.blade.php
│   │   │       ├── _body.blade.php
│   │   │       └── _attachments.blade.php
│   │   └── inboxes/
│   │       ├── index.blade.php
│   │       ├── create.blade.php
│   │       └── edit.blade.php
│   ├── assets/
│   │   ├── css/
│   │   │   └── app.css
│   │   └── js/
│   │       └── app.js
│   └── lang/
│       └── en/
│           └── messages.php
├── routes/
│   ├── web.php
│   └── api.php
├── src/
│   ├── Console/
│   │   └── Commands/
│   │       ├── InstallCommand.php
│   │       └── PurgeOldEmailsCommand.php
│   ├── Contracts/
│   │   ├── InboxServiceInterface.php
│   │   └── SpamAnalyzerInterface.php
│   ├── Exceptions/
│   │   ├── EmailForwardingException.php
│   │   └── InvalidInboxException.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── InboxApiController.php
│   │   │   │   └── InboxEmailApiController.php
│   │   │   ├── InboxController.php
│   │   │   └── InboxEmailController.php
│   │   ├── Middleware/
│   │   │   └── AuthenticateInbox.php
│   │   ├── Requests/
│   │   │   ├── Api/
│   │   │   │   ├── ForwardEmailRequest.php
│   │   │   │   └── SearchEmailsRequest.php
│   │   │   ├── CreateInboxRequest.php
│   │   │   └── UpdateInboxRequest.php
│   │   └── Resources/
│   │       ├── InboxCollection.php
│   │       ├── InboxEmailCollection.php
│   │       ├── InboxResource.php
│   │       └── InboxEmailResource.php
│   ├── Jobs/
│   │   ├── ForwardEmail.php
│   │   └── ProcessSpamAnalysis.php
│   ├── Listeners/
│   │   └── InterceptSentMessage.php
│   ├── Models/
│   │   ├── Inbox.php
│   │   ├── InboxEmail.php
│   │   └── InboxAttachment.php
│   ├── Services/
│   │   ├── SpamAnalysis/
│   │   │   ├── SpamAnalyzer.php
│   │   │   └── SpamRuleRepository.php
│   │   ├── EmailProcessing/
│   │   │   ├── EmailSanitizer.php
│   │   │   └── AttachmentProcessor.php
│   │   ├── FakeInboxManager.php
│   │   └── InboxManager.php
│   ├── Transport/
│   │   └── FakeSmtpTransport.php
│   ├── Facades/
│   │   └── FakeInbox.php
│   ├── Mail/
│   │   └── ForwardedEmailMessage.php
│   └── FakeInboxServiceProvider.php
├── tests/
│   ├── Feature/
│   │   ├── Api/
│   │   │   ├── InboxApiTest.php
│   │   │   └── InboxEmailApiTest.php
│   │   ├── InboxTest.php
│   │   └── InboxEmailTest.php
│   └── Unit/
│       ├── Services/
│       │   ├── FakeInboxManagerTest.php
│       │   └── SpamAnalyzerTest.php
│       └── EmailSanitizerTest.php
└── composer.json