<?php

namespace YourVendor\FakeInbox\Tests\Unit;

use YourVendor\FakeInbox\Services\EmailProcessing\EmailSanitizer;
use Tests\TestCase;

class EmailSanitizerTest extends TestCase
{
    /** @test */
    public function it_removes_scripts_from_html()
    {
        $sanitizer = new EmailSanitizer([
            'allow_scripts' => false,
            'allow_svg' => true,
            'allow_iframes' => true
        ]);

        $html = '<script>alert("XSS")</script><p>Hello</p>';
        $clean = $sanitizer->sanitizeHtml($html);

        $this->assertStringNotContainsString('<script>', $clean);
        $this->assertStringContainsString('<p>Hello</p>', $clean);
    }

    /** @test */
    public function it_removes_svg_when_disabled()
    {
        $sanitizer = new EmailSanitizer([
            'allow_scripts' => true,
            'allow_svg' => false,
            'allow_iframes' => true
        ]);

        $html = '<svg><circle cx="50" cy="50" r="40"/></svg><p>Hello</p>';
        $clean = $sanitizer->sanitizeHtml($html);

        $this->assertStringNotContainsString('<svg>', $clean);
        $this->assertStringContainsString('<p>Hello</p>', $clean);
    }

    /** @test */
    public function it_handles_empty_html()
    {
        $sanitizer = new EmailSanitizer([
            'allow_scripts' => false,
            'allow_svg' => false,
            'allow_iframes' => false
        ]);

        $this->assertEquals('', $sanitizer->sanitizeHtml(null));
        $this->assertEquals('', $sanitizer->sanitizeHtml(''));
    }
}