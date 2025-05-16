<?php

namespace YourVendor\FakeInbox\Tests\Unit\Services\SpamAnalysis;

use YourVendor\FakeInbox\Models\InboxEmail;
use YourVendor\FakeInbox\Services\SpamAnalysis\SpamAnalyzer;
use Tests\TestCase;

class SpamAnalyzerTest extends TestCase
{
    /** @test */
    public function it_analyzes_email_for_spam()
    {
        $config = [
            'threshold' => 5.0,
            'rules_path' => null
        ];

        $analyzer = new SpamAnalyzer($config);
        $email = InboxEmail::factory()->create([
            'subject' => 'Buy cheap viagra',
            'html_body' => '<html>Special offer!</html>'
        ]);

        $result = $analyzer->analyze($email);

        $this->assertIsFloat($result['score']);
        $this->assertIsBool($result['is_spam']);
        $this->assertIsArray($result['rules']);
    }

    /** @test */
    public function it_matches_spam_rules()
    {
        $config = [
            'threshold' => 1.0,
            'rules_path' => null
        ];

        $analyzer = new SpamAnalyzer($config);
        $email = InboxEmail::factory()->create([
            'subject' => 'VIAGRA SPECIAL OFFER!!!'
        ]);

        $result = $analyzer->analyze($email);

        $this->assertGreaterThanOrEqual(1.0, $result['score']);
        $this->assertTrue($result['is_spam']);
    }
}