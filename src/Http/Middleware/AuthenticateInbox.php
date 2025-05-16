<?php

namespace YourVendor\FakeInbox\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use YourVendor\FakeInbox\Models\Inbox;
use YourVendor\FakeInbox\Exceptions\InvalidInboxException;

/**
 * Middleware to verify inbox ownership
 */
class AuthenticateInbox
{
    /**
     * Handle an incoming request
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws InvalidInboxException
     */
    public function handle(Request $request, Closure $next)
    {
        $inbox = $request->route('inbox');
        
        if ($inbox instanceof Inbox && $inbox->user_id !== auth()->id()) {
            throw new InvalidInboxException('You do not own this inbox');
        }

        return $next($request);
    }
}