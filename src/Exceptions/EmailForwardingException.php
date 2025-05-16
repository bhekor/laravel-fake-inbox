<?php

namespace YourVendor\FakeInbox\Exceptions;

use Exception;

/**
 * Exception thrown when email forwarding fails
 */
class EmailForwardingException extends Exception
{
    public function __construct(string $message = "Email forwarding failed", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}