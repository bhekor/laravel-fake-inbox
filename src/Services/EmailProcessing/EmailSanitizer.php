<?php

namespace YourVendor\FakeInbox\Services\EmailProcessing;

use DOMDocument;
use Masterminds\HTML5;

/**
 * Sanitizes email content to remove potentially dangerous elements
 */
class EmailSanitizer
{
    private bool $allowSvg;
    private bool $allowScripts;
    private bool $allowIframes;

    public function __construct(array $config)
    {
        $this->allowSvg = $config['allow_svg'] ?? false;
        $this->allowScripts = $config['allow_scripts'] ?? false;
        $this->allowIframes = $config['allow_iframes'] ?? false;
    }

    /**
     * Sanitize HTML content
     *
     * @param string|null $html
     * @return string
     */
    public function sanitizeHtml(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        $html5 = new HTML5();
        $dom = $html5->loadHTML($html);

        $this->removeDangerousElements($dom);

        return $html5->saveHTML($dom);
    }

    private function removeDangerousElements(DOMDocument $dom): void
    {
        $xpath = new \DOMXPath($dom);

        if (!$this->allowSvg) {
            foreach ($xpath->query('//svg') as $node) {
                $node->parentNode->removeChild($node);
            }
        }

        if (!$this->allowScripts) {
            foreach ($xpath->query('//script') as $node) {
                $node->parentNode->removeChild($node);
            }
        }

        if (!$this->allowIframes) {
            foreach ($xpath->query('//iframe') as $node) {
                $node->parentNode->removeChild($node);
            }
        }
    }
}