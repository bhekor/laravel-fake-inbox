<?php

namespace YourVendor\FakeInbox\Exceptions;

use Exception;

/**
 * Exception thrown for invalid inbox operations
 */
class InvalidInboxException extends Exception
{
    public function __construct(string $message = "Invalid inbox operation", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}